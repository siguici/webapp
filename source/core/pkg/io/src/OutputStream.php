<?php namespace Ske\IO;

class OutputStream implements Output {
    use Stream;

    public function write(string $text, ?int $length = null): int|false {
        return fwrite($this->getStream(), $text, $length);
    }

    public function writeLine(string $line, ?int $length = null): int|false {
        return $this->write($line . PHP_EOL);
    }

    public function writeChar(string $char): int|false {
        return $this->write($char, 1);
    }

    public function print(string $format, ...$vals): int {
        return fprintf($this->getStream(), $format, ...$vals);
    }
}
