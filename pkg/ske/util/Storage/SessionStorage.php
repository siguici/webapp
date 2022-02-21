<?php namespace Ske\Util\Storage;

class SessionStorage extends Storage {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function store(string $key, mixed $value): self {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function stored(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function unstore(string $key): void {
        unset($_SESSION[$key]);
    }

    public function retrieve(string): mixed {
        return $_SESSION[$key] ?? null;
    }
}