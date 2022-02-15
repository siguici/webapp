<?php namespace Ske\Util\Loader;

class ArrayLoader implements Loadable {
    public static function loadFile(string $file, int $flags = 0): mixed {
        if (!is_file($file)) {
            throw new Exception("$file is not a file");
        }

        if (!is_readable($file)) {
            throw new Exception("$file is not readable");
        }

        $data = require $file;

        if (!is_array($data)) {
            throw new Exception("$file does not return an array");
        }

        return $data;
    }

    public static function loadData(mixed $data, int $flags = 0, JSON_OBJECT_AS_ARRAY): mixed {
        return (array) $data;
    }
}