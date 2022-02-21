<?php namespace Ske\Util;

class FtpClient {
    use EventEmitter;

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
        $this->putDir($this->getCwd());
        $this->do('run', $argc, $argv);
    }

    function putFile(string $file, int $mode = FTP_ASCII): void {
        if (!file_exists($file))
            $this->do('error', new \RuntimeException("$file does not exist"));

        $path = $this->getPathOf($file);

        if ($this->ignore->isIgnored($path)) {
            $this->do('ignore', $path);
            return;
        }

        $ftp = $this->ftp;

        if (is_dir($file))
            $this->putDir($file, $mode);
        else $ftp->put($path, $file, $mode) ?
            $this->do('put', $path, $file, $mode) :
            $this->do('error', new \RuntimeException("Failed to put $file"));
    }

    protected function putDir(string $dir, int $mode = FTP_ASCII): void {
        if (!is_dir($dir))
            $this->do('error', new \RuntimeException("$dir is not a directory"));

        $path = $this->getPathOf($dir);

        $ftp = $this->ftp;
        if (!($list = $ftp->mlsd($path))) {
            $ftp->mkdir($path) ? $this->do('mkdir', $path) : $this->do('error', new \RuntimeException("Failed to create $path"));
        }
        else $this->do('mlsd', $path, $list);

        if (is_array($files = scandir($dir))) {
            foreach ($files as $file) {
                if ($file === '.' || $file === '..')
                    continue;
                $this->putFile($dir . DIRECTORY_SEPARATOR . $file);
            }
        }
    }

    public function getPathOf(string $path): string {
        if (!str_starts_with($path = realpath($path), $cwd = realpath($this->getCwd())))
            $this->do('error', new \RuntimeException("$path is not included in $cwd"));

        $path = substr($path, strlen($cwd));
        $path = str_replace('\\', '/', $path);
        if (empty($path))
            $path = '/';
        return $path;
    }

    protected int $timeout = 60;

    public function updateTimeout(int|float $time = 60): void {
        if ($timeout <= $this->ftp->getOption(FTP_TIMEOUT_SEC))
            $this->ftp->setOption(FTP_TIMEOUT_SEC, $this->timeout += $time);
    }
}