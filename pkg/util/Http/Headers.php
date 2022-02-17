<?php namespace Ske\Util\Http;

class Headers {
    public function __construct(array $list = []) {
        $this->update($list);
    }

    protected $list = [];

    public function update(array $list): self {
        foreach ($list as $key => $value) {
            is_int($key) ? $this->headers->add($value) : $this->headers->set($key, $value);
        }
        return $this;
    }

    public function get(string $key): ?string {
        return $this->list[$key] ?? null;
    }

    public function set(string $key, string $value): self {
        $this->list[$key] = $value;
        return $this;
    }

    public function add(string $header): self {
        $header = explode(':', $header, 2);
        $this->set(trim($header[0]), trim($header[1]));
        return $this;
    }
}