<?php namespace Ske\Util;

class CookieStorage extends Storage {
    public function store(string $key, mixed $value = '', int|array $expires_or_options = 0, string $path = '', string $domain = '', bool $secure = false, bool $httponly = false): self {
        if (is_array($expires_or_options)) {
            $expires_or_options = array_merge([
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httponly,
            ], $expires_or_options);
            setcookie($key, $value, $expires_or_options);
        }
        else {
            setcookie($key, $value, $expires_or_options, $path, $domain, $secure, $httponly);
        }
        return $this;
    }

    public function unstore(string $key): void {
        setcookie($key, '', time() - 3600);
    }

    public function stored(string $key): bool {
        return isset($_COOKIE[$key]);
    }

    public function retrieve(string $key): mixed {
        return $_COOKIE[$key] ?? null;
    }
}