<?php namespace Ske\Util;

class OutputStream extends Stream implements Output {
    public function write(string $text, ?int $length = null): int|false {
        return fwrite($this->getStream(), $text, $length);
    }

    public function writeLine(string $line, ?int $length = null): int|false {
        return $this->write($line . PHP_EOL);
    }

    public function writeChar(string $char): int|false {
        return $this->write($char, 1);
    }

    public function print(string $format, ...$args): int {
        return fprintf($this->getStream(), $format, ...$args);
    }

	public function printLine(string $format, ...$args): int {
		return $this->print($format . PHP_EOL, ...$args);
	}
}
