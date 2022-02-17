<?php namespace Ske\Util;

class Locale {
    public function __construct(string $code = 'en-US') {
        $this->setCode($code);
    }

    protected string $code = 'en-US';

    public function setCode(string $code) {
        $this->code = $code;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getLanguage(): string {
        return substr($this->code, 0, 2);
    }

    public function getCountry(): string {
        return substr($this->code, 3, 2);
    }

    public function getVariant(): string {
        return substr($this->code, 6);
    }

    public function __toString(): string {
        return $this->code;
    }
}