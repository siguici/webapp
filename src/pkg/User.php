<?php namespace Ske;

class User {
    protected string $locale = 'en-US';

    public function locale(): ?string {
        return $this->locale;
    }

    public function lang(): ?string {
        return substr($this->locale(), 0, 2);
    }
}