<?php namespace Ske\Util\Http;

abstract class Message {
    public function __construct(array $headers = [], string $body = '') {
        $this->setHeaders($headers);
        $this->setBody($body);
    }

    protected Headers $headers;

    public function setHeaders(array $headers): self {
        if (!$this->headers) {
            $this->headers = new Headers();
        }
        else {
            $this->headers->update($headers);
        }
        return $this;
    }

    public function getHeaders(): Headers {
        return $this->headers;
    }

    protected Body $body;

    public function setBody(string $data): self {
        if (!isset($this->body)) {
            $this->body = new Body($data);
        } else {
            $this->body->setData($data);
        }
        return $this;
    }

    public function getBody(): Body {
        return $this->body;
    }
}