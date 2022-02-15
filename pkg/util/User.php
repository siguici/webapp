<?php namespace Ske\Util;

use Ske\Util\Storage\SessionStorage;

class User {
    public function __construct(string $locale) {
        $this->locale = new Locale($locale);
    }

    public function getLocale(): Locale {
        return $this->locale;
    }

    protected ?Storage $storage = null;

    public function storage(): Storage {
        if (null === $this->storage) {
            $this->storage = new SessionStorage();
        }
        return $this->storage;
    }
}