<?php namespace Ske\Util;

class Form {
    public function __construct(string $action, string $method = 'POST') {
        $this->setAction($action);
        $this->setMethod($method);
    }

    protected string $action;

    public function setAction(string $action): static {
        $this->action = $action;
        return $this;
    }

    public function getAction(): string {
        return $this->action;
    }

    protected string $method;

    public function setMethod(string $method): static {
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST'])) {
            throw new \InvalidArgumentException('Invalid method');
        }
        $this->method = $method;
        return $this;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getType(): int {
        return match($this->getMethod(),
            'GET' => INPUT_GET,
            'POST' => INPUT_POST,
        );
    }

}