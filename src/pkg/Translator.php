<?php namespace Ske;

class Translator {
    public function __construct(array $translations = []) {
        $this->addTranslations($translations);
    }

    protected $translations = [];

    public function addTranslations(array $translations): static {
        foreach ($translations as $translation) {
            $this->addTranslation($translation);
        }
        return $this;
    }

    public function addTranslation(Translation $translation): Translation {
        return $this->translations[] = $translation;
    }

    public function getTranslations(): array {
        return $this->translations;
    }

    public function translate(string $key, ...$args): string {
        foreach ($this->translations as $translation) {
            if ($value = $translation->get($key)) {
                $key = $value;
                break;
            }
        }
        if (count($args)) {
            $key = sprintf($key, ...$args);
        }
        return $key;
    }
}