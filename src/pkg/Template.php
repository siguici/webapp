<?php namespace Ske;

class Template {
    public function __construct(protected string $path, protected array $data = [], protected bool $required = true) {}

    public function render(): string {
        extract($this->data);
        ob_start();
        $render = (string) ($this->required ? require $this->path : include $this->path);
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