#!/usr/bin/env php
<?php

function update_timeout(int|float $time = 60): void {
    global $ftp, $timeout;
    if ($timeout <= ftp_get_option($ftp, FTP_TIMEOUT_SEC))
        ftp_set_option($ftp, FTP_TIMEOUT_SEC, $timeout += $time);
}

function ignore_file(string $file): bool {
    global $ignore;
    foreach ($ignore as $pattern) {
        if (strpos($pattern, '/') === 0) {
            if (fnmatch($pattern, $file))
                return true;
        }
        elseif (fnmatch($pattern, basename($file)))
            return true;
    }
    return false;
}

function upload_file(string $file): void {
    global $ftp, $cwd;
    
    if (file_exists($file) && strpos($file = realpath($file), $cwd) === 0) {
        $path = substr($file, strlen($cwd));
        $path = str_replace('\\', '/', $path);
        if (empty($path))
            $path = '/';

        if (ignore_file($path)) {
            fwrite(STDOUT, "File '$path' ignored" . PHP_EOL);
            return;
        }
        
        if (is_dir($file)) {
            if (!ftp_mlsd($ftp, $path)) {
                fwrite(STDOUT, "Creating directory '$path'..." . PHP_EOL);
                if (ftp_mkdir($ftp, $path))
                    fwrite(STDOUT, "Directory '$path' created" . PHP_EOL);
                else
                    fwrite(STDERR, "Failed to create directory '$path'" . PHP_EOL);
            }
            
            fwrite(STDOUT, "Scanning directory '$path'..." . PHP_EOL);
            if (is_array($files = scandir($file))) {
                fwrite(STDOUT, (count($files) - 2) . " file(s) scanned in '$path'" . PHP_EOL);
                foreach ($files as $name)
                    if ($name !== '.' && $name !== '..')
                        upload_file($file . DIRECTORY_SEPARATOR . $name);
            }
            else
                fwrite(STDERR, "Failed to scan directory '$path'" . PHP_EOL);
        }
        else {
            fwrite(STDOUT, "Uploading file '$path'..." . PHP_EOL);
            if (ftp_put($ftp, $path, $file, FTP_ASCII))
                fwrite(STDOUT, "File '$path' uploaded" . PHP_EOL);
            else
                fwrite(STDERR, "Failed to upload file '$path'" . PHP_EOL);
        }
    }
    else 
        fwrite(STDERR, "No such file or directory '$file'" . PHP_EOL);
}

$cwd = getcwd();

$env = parse_ini_file($cwd . DIRECTORY_SEPARATOR . 'ftp.env', false, INI_SCANNER_TYPED);
extract($env, EXTR_SKIP);

$ignore = [];
if (is_file($cwd . DIRECTORY_SEPARATOR . '.ftpignore'))
    $ignore = file(getcwd() . DIRECTORY_SEPARATOR . '.ftpignore', FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);

fwrite(STDOUT, 'Connecting to FTP server...' . PHP_EOL);
if ($ftp = ftp_ssl_connect($host, $port, $timeout)) {
    fwrite(STDOUT, "Connected to FTP server" . PHP_EOL);
    fwrite(STDOUT, "Logging in to FTP server..." . PHP_EOL);
    if (ftp_login($ftp, $username, $password)) {
        fwrite(STDOUT, "Logged in to FTP server" . PHP_EOL);
        fwrite(STDOUT, "Enabling passive mode..." . PHP_EOL);
        if (ftp_pasv($ftp, true)) {
            fwrite(STDOUT, "Passive mode enabled" . PHP_EOL);
            fwrite(STDOUT, 'Current directory: ' . ftp_pwd($ftp) . PHP_EOL);
            fwrite(STDOUT, "Loading deployment files..." . PHP_EOL);
            upload_file($cwd);
            ftp_close($ftp);
        }
        else {
            fwrite(STDERR, "Failed to enable passive mode" . PHP_EOL);
            exit(1);
        }
    }
    else {
        fwrite(STDERR, 'FTP login failed' . PHP_EOL);
        exit(1);
    }
}
else {
    fwrite(STDERR, 'FTP connection failed' . PHP_EOL);
    exit(1);
}

