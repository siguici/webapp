<?php namespace Ske\Util\Http;

class Response {
    public function __construct(int $statusCode, ?string $reasonPhrase = null, array $headers = [], string $body = '') {
        $this->setStatus($statusCode, $reasonPhrase);
        $this->setHeaders($headers);
        $this->setBody($body);
    }

    protected ResponseStatus $status;

    public function setStatus(int $statusCode, ?string $reasonPhrase = null): self {
        $this->status = new ResponseStatus($statusCode, $reasonPhrase);
        return $this;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function getCode(): int {
        return $this->status->getCode();
    }

    public function getReason(): string {
        return $this->status->getReason();
    }

    public function getType(): string {
        return $this->status->getType();
    }

    protected ?Headers $headers = null;


    public function getHeaders(): Headers {
        return $this->headers;
    }

    public function setHeaders(array $headers): self {
        if ($this->headers === null) {
            $this->headers = new Headers($headers);
        }
        else {
            $this->headers->add($headers);
        }
        return $this;
    }
}
