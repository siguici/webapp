<?php namespace Ske\Util;

abstract Storage {
    abstract public function store(string $key, mixed $value): self;
    abstract public function stored(string $key): bool;
    abstract public function unstore(string $key): void;
    abstract public function retrieve(string $key, mixed $default = null): mixed;
}