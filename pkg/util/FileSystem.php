<?php namespace Ske\Util;

trait FileSystem {
    protected string $pwd = '';

    public function pwd(): string {
        return $this->pwd;
    }

    public function cd(string $dir, bool $force = false): string {
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException("No such directory $dir");
        }
        if (!is_readable($dir)) {
            throw new \InvalidArgumentException("Cannot read directory $dir");
        }
        return $this->pwd = $dir;
    }

    public function ls(string $name = '', bool $recursive = false, bool $all = false): array {
        if ('' === $name) {
            $name = '.';
        }
        if (!is_dir($dir = $name) && !is_dir($dir = $this->pwd . DIRECTORY_SEPARATOR . $name)) {
            throw new \UnexpectedValueException("$name is not a directory");
        }
        $dir = new \DirectoryIterator($dir);
        $files = [];
        foreach ($dir as $file) {
            if (!$all && str_starts_with($file->getFilename(), '.')) {
                continue;
            }
            if ($recursive) {
                if (!$file->isDir() || $file->isDot()) {
                        $files[$name][] = $file->getFilename();
                }
                else {
                    if (!isset($files[$name])) {
                        $files[$name] = [];
                    }
                    $files[$name] += $this->ls($name . DIRECTORY_SEPARATOR . $file->getFilename(), $recursive, $all);
                }
            }
            else {
                $files[] = $file->getFilename();
            }
        }
        return $files;
    }

    public function cat(string $name): string {
        if (!is_file($name)) {
            throw new \UnexpectedValueException("$name is not a file");
        }
        if (!is_readable($name)) {
            throw new \UnexpectedValueException("Cannot read file $name");
        }
        return file_get_contents($name);
    }

    public function mkdir(string $name, bool $recursive = false, int $mode = 0777): void {
        if (is_dir($name)) {
            throw new \RuntimeException("$name is already a directory");
        }
        if (!mkdir($name, $mode, $recursive)) {
            throw new \RuntimeException("Cannot create directory $name");
        }
    }

    public function rm(string $name, bool $recursive = false): void {
        if (!file_exists($file = $name) && !file_exists($file = $this->pwd . DIRECTORY_SEPARATOR . $name)) {
            throw new \RuntimeException("Cannot remove '$name': No such file or directory");
        }

        if (!$recursive && is_dir($file)) {
            throw new \RuntimeException("Cannot remove '$name': Is a directory");
        }

        if (is_file($file)) {
            if (!unlink($file)) {
                throw new \RuntimeException("Cannot remove '$name': Permission denied");
            }
        }
        else {
            $dir = new \DirectoryIterator($file);
            foreach ($dir as $file) {
                $this->rm($name . DIRECTORY_SEPARATOR . $file->getFilename(), $recursive);
            }
            if (!rmdir($file->getPathname())) {
                throw new \RuntimeException("Cannot remove '$name': Permission denied");
            }
        }
    }

    public function touch(string $name, int $mode = 0777): void {
        if (file_exists($name)) {
            throw new \RuntimeException("Cannot touch '$name': File exists");
        }
        if (!touch($name, $mode)) {
            throw new \RuntimeException("Cannot touch '$name': Permission denied");
        }
    }
}