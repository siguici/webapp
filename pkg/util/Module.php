<?php namespace Ske\Util;

class Module {
    public function __construct(protected string $path, protected array $data = [], protected bool $required = true) {}

    public function import(): mixed {
        if (!is_file($this->path)) {
            if ($this->required) {
                throw new \RuntimeException("Module '{$this->path}' not found");
            } else {
                return null;
            }
        }
        extract($this->data);
        return $this->required ? require $this->path : include $this->path;
    }

    public function __set(string $name, mixed $value): void {
        $this->data[$name] = $value;
    }

    public function __get(string $name): mixed {
        return $this->data[$name];
    }
}