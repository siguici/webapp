<?php namespace Ske\Util\Http;

class Body implements \IteratorAggregate, \ArrayAccess {
    public function __construct(string $data) {
        $this->setData($data);
    }

    protected array $data;

    public function getData(): string {
        return json_encode($this->data);
    }

    public function setData(string $data): void {
        $data = json_decode($data, true, PHP_INT_MAX);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON given');
        }
        $this->data = $data;
    }

    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->data);
    }

    public function offsetExists(string $offset): bool {
        return isset($this->data[$offset]);
    }

    public function offsetGet(string $offset): mixed {
        return $this->data[$offset];
    }

    public function offsetSet(string $offset, mixed $value): void {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(string $offset): void {
        unset($this->data[$offset]);
    }

    public function __toString(): string {
        return $this->getData();
    }

    public function __debugInfo(): array {
        return $this->data;
    }

    public function __get(string $name): mixed {
        return $this->offsetGet($name);
    }

    public function __set(string $name, mixed $value): void {
        $this->offsetSet($name, $value);
    }

    public function __isset(string $name): bool {
        return $this->offsetExists($name);
    }

    public function __unset(string $name): void {
        $this->offsetUnset($name);
    }
}