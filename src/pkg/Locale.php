<?php namespace Ske;

class Locale {
    protected string $q = 'en-US';

    public function __construct(string $q = 'en-US') {
        $this->q = $q;
    }

    public function getLanguage(): string {
        return substr($this->q, 0, 2);
    }

    public function getCountry(): string {
        return substr($this->q, 3, 2);
    }

    public function getVariant(): string {
        return substr($this->q, 6);
    }
}