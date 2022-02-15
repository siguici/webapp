<?php namespace Ske\Util;

class Template extends Module {
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