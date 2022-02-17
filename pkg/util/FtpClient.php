<?php namespace Ske\Util;

class FtpClient {
    public function __construct(public Ftp $ftp, protected string $cwd) {
        $this->setCwd($cwd);
        $this->ignore = new Dotignore();
    }

    public Dotignore $ignore;

    public function setCwd(string $cwd): self {
        chdir($this->cwd = $cwd);
        if (is_file($ftpIgnore = $cwd . '.ftpignore'))
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

    function putFile(?string $file, int $mode = FTP_ASCII): void {
        if (!file_exists($file) || !str_starts_with($file = realpath($file), $cwd = $this->getCwd()))
            throw new \Exception("Invalid file $file");

        $path = substr($file, strlen($cwd));
        $path = str_replace('\\', '/', $path);
        if (empty($path))
            $path = '/';

        if ($this->ignore->contains($path)) {
            return;
        }

        $ftp = $this->ftp;

        if (is_dir($file)) {
            if (!$ftp->mlsd($path)) {
                if (!$ftp->mkdir($path))
                    throw new \Exception("Failed to create directory $path");
            }

            if (is_array($files = scandir($file))) {
                foreach ($files as $name)
                    if ($name !== '.' && $name !== '..')
                        $this->putFile($file . DIRECTORY_SEPARATOR . $name);
            }
        }
        else {
            if (!$ftp->put($path, $file, $mode))
                throw new \Exception("Failed to upload $file");
        }
    }

    protected int $timeout = 60;

    public function updateTimeout(int|float $time = 60): void {
        if ($timeout <= $this->ftp->getOption(FTP_TIMEOUT_SEC))
            $this->ftp->setOption(FTP_TIMEOUT_SEC, $this->timeout += $time);
    }
}