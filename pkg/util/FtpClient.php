<?php namespace Ske\Util;

class FtpClient {
    public function __construct(public Ftp $ftp, protected string $cwd) {
        $this->ignore = new Dotignore();
        $this->setCwd($cwd);
    }

    public Dotignore $ignore;

    public function setCwd(string $cwd): self {
        if (!is_dir($cwd)) {
            throw new \InvalidArgumentException("$cwd is not a directory");
        }
        chdir($this->cwd = realpath($cwd) . DIRECTORY_SEPARATOR);
        if (is_file($ftpIgnore = $this->cwd . '.ftpignore'))
            $this->ignore->loadFile($ftpIgnore);
        return $this;
    }

    public function getCwd(): string {
        return $this->cwd;
    }

    public function run(int $argc, array $argv): void {
        if (!$this->ftp->pasv(true))
            throw new \Exception('Failed to enable passive mode');
        $this->putFile($this->getCwd());
    }

    function putFile(string $file, int $mode = FTP_ASCII): void {
        if (!file_exists($file))
            throw new \Exception("$file does not exist");

        if (!str_starts_with($file = realpath($file), $cwd = realpath($this->getCwd())))
            throw new \Exception("$file is not included in $cwd");

        $path = substr($file, strlen($cwd));
        $path = str_replace('\\', '/', $path);
        if (empty($path))
            $path = '/';

        if ($this->ignore->isIgnored($path)) {
            echo "Ignoring $path" . PHP_EOL;
            return;
        }

        $ftp = $this->ftp;

        if (is_dir($file)) {
            if (!$ftp->mlsd($path)) {
                if (!$ftp->mkdir($path))
                    throw new \Exception("Failed to create directory $path");
                echo "Created directory $path" . PHP_EOL;
            }

            if (is_array($files = scandir($file))) {
                foreach ($files as $name)
                    if ($name !== '.' && $name !== '..')
                        $this->putFile($file . DIRECTORY_SEPARATOR . $name);
            }
        }
        else {
            if (!$ftp->put($path, $file, $mode))
                throw new \Exception("Failed to put $file");
            echo "Put $file" . PHP_EOL;
        }
    }

    protected int $timeout = 60;

    public function updateTimeout(int|float $time = 60): void {
        if ($timeout <= $this->ftp->getOption(FTP_TIMEOUT_SEC))
            $this->ftp->setOption(FTP_TIMEOUT_SEC, $this->timeout += $time);
    }
}