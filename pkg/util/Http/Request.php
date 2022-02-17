<?php namespace Ske\Util\Http;

class Request {
    public function __construct(string $url, string $method = 'GET', array $headers = [], string $body = '') {
        $this->setLine($method, $url);
        $this->setHeaders($headers);
        $this->setBody($body);
    }

    protected RequestLine $line;

    public function setLine(string $method, string $url): self {
        if (!isset($this->line)) {
            $this->line = new RequestLine($method, $url);
        } else {
            $this->line->setMethod($method);
            $this->line->setUrl($url);
        }
        return $this;
    }

    public function getLine(): RequestLine {
        return $this->line;
    }

    public function getMethod(): string {
        return $this->line->getMethod();
    }

    public function getUrl(): string {
        return $this->line->getUrl();
    }
}