<?php namespace Ske\Util\Http;

class Query implements \IteratorAggregate, \Countable {
    public function __construct(string $string) {
        $this->setString($string);
    }

    protected string $string;

    public function setString(string $string): self {
        $this->string = $string;
        return $this;
    }

    public function getString(): string {
        return $this->string;
    }

    public function getArray(): array {
        parse_str($this->string, $array);
        return $array;
    }

    public function getValue(string $key, mixed $default = null): mixed {
        return $this->getArray()[$key] ?? $default;
    }

    public function getValues(array $keys, mixed $default = null): array {
        $array = $this->getArray();
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $array[$key] ?? null;
        }
        return $values;
    }

    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->getArray());
    }

    public function count(): int {
        return count($this->getArray());
    }

    public function __toString(): string {
        return $this->getString();
    }
}