<?php namespace Ske\Util;

use Ske\Util\Loader\JsonLoader;

class TranslationFile extends Translation {
    public function __construct(string $name, $file) {
        parent::__construct($name, JsonLoader::loadFile($file, JSON_OBJECT_AS_ARRAY));
    }
}