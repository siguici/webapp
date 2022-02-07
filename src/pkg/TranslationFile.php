<?php namespace Ske\Util;

class TranslationFile extends Translation {
    public function __construct(string $name, $file) {
        if (!is_file($file)) {
            throw new \RuntimeException("$file is not found");
        }

        if (!is_readable($file)) {
            throw new \RuntimeException("$file is not readable");
        }

        if (!($data = @file_get_contents($file))) {
            throw new \RuntimeException("$file is empty");
        }

        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(json_last_error_msg());
        }

        parent::__construct($name, $data);
    }
}