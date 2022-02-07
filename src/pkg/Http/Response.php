<?php namespace Ske\Util\Http;

class Response {
    public function __construct(int $statusCode, ?string $reasonPhrase = null, array $headers = [], string $body = '') {
        $this->setStatus($statusCode, $reasonPhrase);
        $this->setHeaders($headers);
        $this->setBody($body);
    }

    protected Status $status;

    public function getStatus(): Status {
        return $this->status;
    }

    public function setStatus(int $statusCode, ?string $reasonPhrase = null): self {
        $this->status = new Status($statusCode, $reasonPhrase);
        return $this;
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

    protected Body $body;

    public function getBody(): Body {
        return $this->body;
    }

    public function setBody(string $body): self {
        $this->body = new Body($body);
        return $this;
    }
}
