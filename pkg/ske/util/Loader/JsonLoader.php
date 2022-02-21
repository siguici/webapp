<?php namespace Ske\Util\Loader;

class JsonLoader implements Loadable {
    public static function loadFile(string $file, int $flags = 0, int $depth = 512): mixed {
        if (!is_file($file)) {
            throw new Exception("$file is not found");
        }

        if (!is_readable($file)) {
            throw new Exception("$file is not readable");
        }

        if (!($data = @file_get_contents($file))) {
            throw new Exception("$file is empty");
        }

        return self::loadData($data, $flags, $depth);
    }

    public static function LoadData(mixed $data, int $flags = 0, int $depth = 512): mixed {
        $data = json_decode($data, null, $depth, $flags);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON data given");
        }

        return $data;
    }
}
