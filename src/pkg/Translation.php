<?php namespace Ske;

class Translation {
    public function __construct(protected string $name, array $data = []) {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    protected array $data = [];

    public function set(string $key, string $value): void {
        $this->data[$key] = $value;
    }

    public function get(string $key): ?string {
        return $this->data[$key] ?? null;
    }
}