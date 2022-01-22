<?php namespace Ske\IO;

interface Input {
    public function read(int $length): string|false;
    public function readLine(int $length): string|false;
    public function readChar(): string|false;
    public function scan(string $format, &...$vars): array|int|false|null;
}
