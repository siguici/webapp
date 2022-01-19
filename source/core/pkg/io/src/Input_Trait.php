<?php namespace Ske\IO;

trait Input_Trait {
    use Stream_Trait;

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
}
