<?php

use Ske\Util\{Ftp, FtpClient};

$ftp = new Ftp(env('FTP_HOST'), env('FTP_PORT'), env('FTP_TIMEOUT'), env('FTP_SECURE'));
if (!$ftp->login(env('FTP_USERNAME'), env('FTP_PASSWORD'))) {
    fprintf(
        STDERR,
        'Enable to login as %s' . PHP_EOL,
        env('FTP_USERNAME')
    );
    exit(1);
}

$ftpClient = new FtpClient($ftp, getcwd());
$ftpClient->run($argc, $argv);