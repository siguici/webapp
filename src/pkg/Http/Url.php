<?php namespace Ske\Util\Http;

class Url {
    public function __construct(string $address) {
        $this->setAddress($address);
    }

    protected string $address = '';

    public setAddress(string $address): static {
        $this->address = $address;
        return $this;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getScheme(): string {
        return parse_url($this->getAddress(), PHP_URL_SCHEME);
    }

    public function getHost(): string {
        return parse_url($this->getAddress(), PHP_URL_HOST);
    }

    public function getPort(): int {
        return parse_url($this->getAddress(), PHP_URL_PORT);
    }

    public function getPath(): string {
        return parse_url($this->getAddress(), PHP_URL_PATH);
    }

    public function getQuery(): string {
        return new Query(parse_url($this->getAddress(), PHP_URL_QUERY));
    }

    public function getFragment(): string {
        return parse_url($this->getAddress(), PHP_URL_FRAGMENT);
    }

    public function getUser(): string {
        return parse_url($this->getAddress(), PHP_URL_USER);
    }

    public function getPassword(): string {
        return parse_url($this->getAddress(), PHP_URL_PASS);
    }

    public function getAuthority(): string {
        return parse_url($this->getAddress(), PHP_URL_USER) . ':' . parse_url($this->getAddress(), PHP_URL_PASS) . '@' . parse_url($this->getAddress(), PHP_URL_HOST);
    }

    public function __toString(): string {
        return $this->getAddress();
    }
}