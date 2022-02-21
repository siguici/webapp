<?php namespace Ske\Util\Loader;

interface Loadable {
    /**
     * @param  string $file  The file to load
     * @param  int    $flags The flags to use
     * @return mixed         The data loaded
     */
    public static function loadFile(string $file, int $flags = 0): mixed;

    /**
     * @param  mixed $data  The data to load
     * @param  int   $flags The flags to use
     * @return mixed        The data loaded
     */
    public static function loadData(mixed $data, int $flags = 0): mixed;
}