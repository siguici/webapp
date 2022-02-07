<?php namespace Ske\Util;

use Ske\Util\InputVar\SessionStorage;

class User {
    public function __construct(string $locale) {
        $this->locale = new Locale($locale);
    }

    public function getLocale(): Locale {
        return $this->locale;
    }
}