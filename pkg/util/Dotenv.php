<?php namespace Ske\Util;

class Dotenv {
    public function __construct(string $root) {
        $this->setRoot($root);
    }

    protected string $root;

    public function setRoot(string $root) {
        if (!is_dir($root)) {
            throw new \InvalidArgumentException("No such directory $root");
        }
        if (!is_readable($root)) {
            throw new \InvalidArgumentException("Cannot read directory $root");
        }
        $this->root = realpath($root) . DIRECTORY_SEPARATOR;
    }

    public function getRoot(): string {
        return $this->root;
    }

    public function load($name = '.env'): Env {
        if (!is_file($file = $name) && !is_file($file = $this->root . $name)) {
            throw new \InvalidArgumentException("No such file $name in $this->root");
        }
        if (!is_readable($file)) {
            throw new \InvalidArgumentException("Cannot read file $name in $this->root");
        }
        $env = new Env();
        foreach ((array) parse_ini_file($file, true, INI_SCANNER_TYPED) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $env->set(strtoupper($key . '_' . $k), $v);
                }
            }
            else {
                $env->set(strtoupper($key), $value);
            }
        }
        return $env;
    }
}