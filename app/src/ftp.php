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

(new FtpClient($ftp, getcwd()))
->on('error', function (\Throwable $e) {
    fprintf(
        STDERR,
        '%s' . PHP_EOL,
        $e->getMessage()
    );
})
->on('put', function (string $remote, string $local, int $mode = FTP_ASCII) {
    fprintf(
        STDOUT,
        'Uploaded %s from %s' . PHP_EOL . str_repeat("\007", 10),
        $remote,
        $local
    );
})
->on('get', function (string $remote, string $local) {
    fprintf(
        STDOUT,
        'Downloaded %s to %s' . PHP_EOL,
        $remote,
        $local
    );
})
->on('mlsd', function (string $path) {
    fprintf(
        STDOUT,
        '%s directory accessed' . PHP_EOL,
        $path
    );
})
->on('mkdir', function (string $dir) {
    fprintf(
        STDOUT,
        'Created directory %s' . PHP_EOL,
        $dir
    );
})
->on('rmdir', function (string $dir) {
    fprintf(
        STDOUT,
        'Removed directory %s' . PHP_EOL,
        $dir
    );
})
->on('run', function (int $argc, array $argv) {
    fprintf(
        STDOUT,
        'Command %s done.' . PHP_EOL,
        $argc > 1 ? $argv[1] : $argv[0]
    );
})
->run($argc, $argv);