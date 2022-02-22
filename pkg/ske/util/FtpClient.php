<?php namespace Ske\Util;

class FtpClient {
    use EventEmitter;

    public function __construct(public Ftp $ftp, protected string $cwd) {
        $this->setCwd($cwd);
    }

    public function setCwd(string $cwd): self {
        if (!is_dir($cwd)) {
            throw new \InvalidArgumentException("$cwd is not a directory");
        }
        chdir($this->cwd = realpath($cwd));
        return $this;
    }

    public function getCwd(): string {
        return $this->cwd;
    }

    public function run(int $argc, array $argv): void {
        if ($argc > 1) {
            match ($argv[1]) {
                'put' => $this->put(...array_slice($argv, 2)),
                'get' => $this->get(...array_slice($argv, 2)),
                default => $this->help(),
            };
        }
        else $this->help();
    }

    public function help(): void {
        echo <<<USAGE
Usage: ftp [command] [arguments]
Commands:
    put       Upload files
    get       Download files

USAGE;
    }

    public function put(string ...$files): void {
        if (!$this->ftp->pasv(true))
            $this->do('error', new \RuntimeException('Failed to enable passive mode'));
        else
            $this->do('pasv', true);

        if (empty($files)) {
            $this->putDir($this->getCwd());
        }
        else {
            foreach ($files as $file) {
                if (!file_exists($file) && !file_exists($file = $this->getCwd() . $file)) {
                    $this->do('error', new \RuntimeException("$file does not exist"));
                    continue;
                }
                is_dir($file) ? $this->putDir($file) : $this->putFile($file);
            }
        }
    }

    function putFile(string $file, int $mode = FTP_ASCII, ?Ignore $ignore = null): void {
        if (!is_file($file)) {
            $this->do('error', new \RuntimeException("$file is not a file"));
            return;
        }
        $file = realpath($file);

        if (!($path = $this->getPathOf($file, $ignore))) return;

        $this->ftp->put($path, $file, $mode) ?
            $this->do('put', $path, $file, $mode) :
            $this->do('error', new \RuntimeException("Failed to put $file"));
    }

    public function putDir(string $dir, int $mode = FTP_ASCII, ?Ignore $ignore = null): void {
        if (!is_dir($dir)) {
            $this->do('error', new \RuntimeException("$dir is not a directory"));
            return;
        }
        $dir = realpath($dir);

        if(is_file($ftpignore = $dir . DIRECTORY_SEPARATOR . '.ftpignore')) {
            $ftpignore = new Dotignore($ftpignore);
            if (isset($ignore)) {
                $ignore->addIncludePatterns($ftpignore->getIncludePatterns());
                $ignore->addExcludePatterns($ftpignore->getExcludePatterns());
            }
            else $ignore = $ftpignore;
        }

        if (!($path = $this->getPathOf($dir, $ignore))) return;

        $ftp = $this->ftp;

        if (!($list = $ftp->mlsd($path))) {
            $ftp->mkdir($path) ? $this->do('mkdir', $path) : $this->do('error', new \RuntimeException("Failed to create $path"));
        }
        else $this->do('mlsd', $path, $list);

        $dir = new \DirectoryIterator($dir);
        foreach ($dir as $file) {
            if ($file->isDot()) continue;
            $file->isDir() ?
                $this->putDir($file->getPathname(), $mode, $ignore) :
                $this->putFile($file->getPathname(), $mode, $ignore);
        }
    }

    public function getPathOf(string $path, ?Ignore $ignore = null): ?string {
        if (!str_starts_with($path, $cwd = $this->getCwd())) {
            $this->do('error', new \RuntimeException("$path is not included in $cwd"));
            return null;
        }

        $path = substr($path, strlen($cwd));
        $path = str_replace('\\', '/', $path);
        if (empty($path))
            $path = '/';

        if ($ignore?->isIgnored($path)) {
            $this->do('ignore', $path);
            return null;
        }

        return $path;
    }

    protected int $timeout = 60;

    public function updateTimeout(int|float $time = 60): void {
        if ($timeout <= $this->ftp->getOption(FTP_TIMEOUT_SEC))
            $this->ftp->setOption(FTP_TIMEOUT_SEC, $this->timeout += $time);
    }
}