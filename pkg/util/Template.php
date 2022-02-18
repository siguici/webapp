<?php namespace Ske\Util;

class Template extends Module {
    public function save(?string $path = null): string {
        $content = file_get_contents($this->getPath());
        if (
            preg_match_all('/\$\{([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\}/', $content, $varsNames) ||
            preg_match_all('/\$([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $content, $varsNames)
        ) {
            foreach ($varsNames[1] as $nameKey => $varName) {
                if (!$this->varExists($varName)) {
                    throw new \RuntimeException("Missing variable ($varName)");
                }
                $content = str_replace($varsNames[0][$nameKey], $this->getVar($varName), $content);
            }
        }
        if (isset($path)) {
            file_put_contents($path, $content, LOCK_EX);
        }
        return $content;
    }
}