<?php namespace Ske\Util;

/**
 * Class Dotignore - A class to handle .*ignore files
 *
 * @package ske/util
 * @author  SIGUI Kessé Emmanuel <developer@sikessem.com>
 * @link    https://pkg.sikessem.com/ske/util/Dotignore
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class Dotignore extends Ignore {
    public function __construct(string $file) {
        parent::__construct(self::load($file));
        $this->file = $file;
    }

    protected string $file;

    public function getFile(): string {
        return $this->file;
    }

    public static function load(string $file): array {
        if (!\is_file($file)) {
            throw new \InvalidArgumentException("$file is not a file");
        }

        if (!\is_readable($file)) {
            throw new \InvalidArgumentException("$file is not readable");
        }

        return \file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
}