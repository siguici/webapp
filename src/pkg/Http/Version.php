<?php namespace Ske\Util\Http;

trait Version {
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