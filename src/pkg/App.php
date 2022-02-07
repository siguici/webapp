<?php namespace Ske\Util;

class App {
    public function __construct(string ...$locales) {
        $this->setLocales(...$locales);
    }

    protected $locales = [];

    public function setLocales(string ...$locales) {
        foreach ($locales as $locale) {
            $this->setLocale($locale);
        }
    }

    public function setLocale(string $locale) {
        $this->locales[$locale] = new Locale($locale);
    }

    public function getLocales(): array {
        return $this->locales;
    }

    public function getLangs(): array {
        $langs = [];
        foreach ($this->getLocales() as $locale) {
            $langs[] = $locale->getLanguage();
        }
        return $langs;
    }
}