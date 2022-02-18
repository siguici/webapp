<?php namespace Ske\Util;

class Module {
    public function __construct(string $path, array $vars = []) {
        $this->setPath($path);
        $this->setVars($vars);
    }

    protected string $path;

    public function setPath(string $path): self {
        if (!is_file($path)) {
            throw new \InvalidArgumentException("$path is not a file");
        }

        $this->path = $path;
        return $this;
    }

    public function getPath(): string {
        return $this->path;
    }

    protected bool $required = false;

    public function required(): self {
        $this->required = true;
        return $this;
    }

    protected bool $once = false;

    public function once(): self {
        $this->once = true;
        return $this;
    }

    protected array $vars = [];

    public function setVars(array $vars): self {
        foreach ($vars as $key => $value) {
            $this->setVar($key, $value);
        }
        return $this;
    }

    public function setVar(string $name, mixed $value): self {
        if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $name)) {
            throw new \InvalidArgumentException("$name is not a valid variable name");
        }
        $this->vars[$name] = $value;
        return $this;
    }

    public function getVars(): array {
        return $this->vars;
    }

    public function getVar(string $name): mixed {
        return $this->vars[$name];
    }

    public function varExists(string $name): bool {
        return isset($this->vars[$name]);
    }

    public function removeVar(string $name): self {
        unset($this->vars[$name]);
        return $this;
    }

    public function __set(string $name, mixed $value): void {
        $this->setVar($name, $value);
    }

    public function __get(string $name): mixed {
        return $this->getVar($name);
    }

    public function __isset(string $name): bool {
        return $this->varExists($name);
    }

    public function __unset(string $name): void {
        $this->removeVar($name);
    }

    public function import(): mixed {
        if (!is_file($this->path)) {
            if ($this->required) {
                throw new \RuntimeException("Module '{$this->path}' not found");
            } else {
                return null;
            }
        }
        extract($this->getVars());
        return $this->required ? ($this->once ? require_once $this->path : require $this->path) : ($this->once ? include_once $this->path : include $this->path);
    }

    public function render(): string {
        ob_start();
        $render = (string) $this->import();
        if (is_numeric($render))
            $render = ob_get_clean();
        else
            ob_end_clean();
        return $render;
    }

    public function __toString() {
        return $this->render();
    }
}