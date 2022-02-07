<?php namespace Ske\Util;

use Ske\Util\InputVar\InputEnv;

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

    protected Input $input = null;

    public function input(): Input {
        if (!$this->input) {
            $this->input = new InputEnv();
        }
        return $this->input;
    }

}