<?php namespace Ske\Util\Loader;

class IniLoader implements Loadable {
    public static function loadFile(string $file, int $flags = 0, bool $process_sections = false): mixed {
        $data = parse_ini_file($file, $process_sections, $flags);

        if ($data === false) {
            throw new Exception("Unable to parse $file");
        }

        return $data;
    }

    public static function loadData(mixed $data, int $flags = 0, bool $process_sections = false): mixed {
        $data = parse_ini_string($data, $process_sections, $flags);

        if ($data === false) {
            throw new Exception("Unable to parse INI data");
        }

        return $data;
    }
}
