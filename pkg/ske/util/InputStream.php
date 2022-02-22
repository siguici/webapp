<?php namespace Ske\Util;

class InputStream extends Stream implements Input {
    public function read(int $length): string|false {
        return fread($this->getStream(), $length);
    }

    public function readLine(int $length): string|false {
        return fgets($this->getStream(), $length);
    }

    public function readChar(): string|false {
        return fgetc($this->getStream());
    }

    public function scan(string $format, &...$vars): array|int|false|null {
        return fscanf($this->getStream(), $format, ...$vars);
    }

	public function getStreamContents(?int $length = null, int $offset = -1): string|false {
		return stream_get_contents($this->getStream(), $length, $offset);
	}

	public function getStreamLine(int $length = 0, string $ending = PHP_EOL): string|false {
		return stream_get_line($this->getStream(), $length, $ending);
	}
}
