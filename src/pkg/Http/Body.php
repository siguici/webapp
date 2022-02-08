<?php namespace Ske\Util\Http;

class Body {
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
}