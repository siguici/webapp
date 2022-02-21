<?php namespace Ske\Util;

class Env implements \ArrayAccess, \IteratorAggregate, \Countable {
    public function __construct(array $options = []) {
        foreach ($options as $key => $value) {
            $this->set($key, $value);
        }
    }

    protected array $options;

    public function set(string $key, mixed $value): mixed {
        $value = match (true) {
            in_array($value, ['null', 'Null', 'NULL', 'nil', 'Nil', 'NIL', 'none', 'NONE'], true) => null,
            in_array($value, ['true', 'True', 'TRUE', 'on', 'On', 'ON', 'yes', 'Yes', 'YES', 't', 'T', 'y', 'Y', '1'], true) => true,
            in_array($value, ['false', 'False', 'FALSE', 'off', 'Off', 'OFF', 'no', 'No', 'NO', 'f', 'F', 'n', 'N', '0'], true) => false,
            is_numeric($value) => is_int(strpos($value, '.')) ? (float) $value : (int) $value,
            default => $value,
        };
        return $this->options[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->options[$key] ?? $default;
    }

    public function isset(string $key): bool {
        return isset($this->options[$key]);
    }

    public function unset(string $key): void {
        unset($this->options[$key]);
    }

    public function offsetExists(mixed $offset): bool {
        return $this->isset($offset);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, $value): void {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void {
        $this->unset($offset);
    }

    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->options);
    }

    public function count(): int {
        return count($this->options);
    }

    public function __set(string $key, mixed $value): void {
        $this->set($key, $value);
    }

    public function __get(string $key): mixed {
        return $this->get($key);
    }

    public function __isset(string $key): bool {
        return $this->isset($key);
    }

    public function __unset(string $key): void {
        $this->unset($key);
    }

    public function __debugInfo(): array {
        return $this->options;
    }
}