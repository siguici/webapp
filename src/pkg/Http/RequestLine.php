<?php namespace Ske\Util\Http;

class RequestLine
{
    public function __construct(string $method, string $url, string $version = 'HTTP/1.1')
        $this->setMethod($method)
            ->setUrl($url)
            ->setVersion($version);
    }

    protected string $method;

    public function setMethod(string $method): self {
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE'])) {
            throw new \InvalidArgumentException("Invalid method $method given");
        }
        $this->method = $method;
        return $this;
    }

    public function getMethod(): string {
        return $this->method;
    }

    protected ?Url $url = null;

    public function setUrl(string $url): self {
        if (!isset($this->url)) {
            $this->url = new Url($url);
        }
        else {
            $this->url->setUrl($url);
        }
        return $this;
    }

    protected string $version = 'HTTP/1.1';

    public function setVersion(string $version): self {
        if (!preg_match('/^HTTP\/[0-9](?:\.[0-9])?$/', $version)) {
            throw new \InvalidArgumentException("Invalid version $version given");
        }
        $this->version = $version;
        return $this;
    }

    public function getVersion(): string {
        return $this->version;
    }
}