<?php namespace Ske\Util\Input;

class InputVar {
    public function __construct(int $type, array &$data) {
        $this->setType($type);
        $this->setData($data);
    }

    protected array $data = [];

    public function setData(array &$data) {
        $this->data = &$data;
    }

    public function getData(): array {
        return $this->data;
    }

    public function setVar(string $key, mixed $value): self {
        $this->data[$key] = $value;
        return $this;
    }

    public function getVar(string $key = null, mixed $default = null) {
        return  ?? $default;
    }

    public function getVar(string $key, mixed $default = null, int $filter = FILTER_DEFAULT, array|int $options = 0): mixed {
        return filter_var($this->data[$key] ?? $default, $filter, $options);
    }

    public function getVars(array $keys, mixed $default, array|int $options = FILTER_DEFAULT, bool $add_empty = true): array|false|null {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->data[$key] ?? $default;
        }
        return filter_var_array($data, $options, $add_empty);
    }

    protected int $type;

    public function setType(int $type): self {
        if (!in_array($type, [INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV])) {
            throw new \InvalidArgumentException('Invalid input type given');
        }
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function getValue(string $name, int $filter = FILTER_DEFAULT, array|int $options = 0): mixed {
        return filter_input($this->getType(), $name, $filter, $options);
    }

    public function getValues(array|int $options = FILTER_DEFAULT, bool $add_empty = true): array|false|null): array|false|null {
        return filter_input_array($this->getType(), $options, $add_empty);
    }

    public function keyExists(string $name): bool {
        return filter_has_var($this->getType(), $name);
    }

    public function keysExist(array $names): bool {
        foreach ($names as $name) {
            if ($this->keyExists($name)) {
                return false;
            }
        }
        return true;
    }
}