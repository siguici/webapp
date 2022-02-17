<?php namespace Ske\Util;

class IgnoreList {
    public function __construct(array $lines = []) {
        $this->setList($lines);
    }

    protected array $lines = [];

    public function setList(array $lines) {
        $this->lines = [];
        foreach ($lines as $line) {
            $this->addLine($line);
        }
    }

    public function addLines(array $lines) {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
    }

    public function addLine($line) {
        $this->list[] = $line;
    }

    public function getList(): array {
        return $this->lines;
    }

    public function ignored(string $name): bool {
        foreach ($this->getList() as $line) {
            if (str_starts_with($line, '/')) {
                if (fnmatch($line, $name))
                    return true;
            }
            elseif (fnmatch($line, basename($name)))
                return true;
        }
        return false;
    }

    public function loadFile(string $file): self {
        if (empty($file)) {
            throw new \InvalidArgumentException('File name cannot be empty');
        }

        if (!\is_file($file)) {
            throw new \InvalidArgumentException("$file does not exist");
        }

        if (!\is_readable($file)) {
            throw new \InvalidArgumentException("$file is not readable");
        }
        $this->setList(\file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        return $this;
    }
}