<?php

require_once __DIR__ . "/php_packages/autoload.php";

function values(string $type): array {
    static $values;
    if (!isset($values[$type])) {
        $values[$type] = ($path = pathOf("res.values.$type", '.json')) ? json_decode(file_get_contents($path), true) : [];
    }
    return $values[$type];
}

function value(string $type, string $name, string ...$data): string {
    $value = values($type)[$name] ?? $name;
    if (is_array($value)) {
        $value = $value[locale()] ?? $value[lang()] ?? $value['_'] ?? $name;
        if (is_array($value)) {
            $value = $value[locale()] ?? $value['_'] ?? $name;
        }
    }
    if (!empty($data)) {
        $value = sprintf($value, ...$data);
    }
    return $value;
}

function text(string $name, string ...$data): string {
    return value('texts', $name, ...$data);
}

function locale(): string {
    return 'fr_CI';
}

function lang(): string {
    return substr(locale(), 0, 2);
}

function view (string $name, array $data = []): ?string {
    $view = null;
    if ($path = pathOf("res.views.$name", '.php')) {
        extract($data);
        ob_start();
        $view = (string) require $path;
        if (is_numeric($view))
            $view = ob_get_clean();
        else
            ob_end_clean();
    }
    return $view;
}

function pathOf(string $name, string $extension = ''): ?string {
    return file_exists($path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $name) . $extension) ? $path : null;
}

function send(null|int|string $content = null): void {
    if (!isset($content))
        exit;
    exit($content);
}

function style(string $name): string {
    return url("static.$name", '.css');
}

function script(string $name): string {
    return url("static.$name", '.js');
}

function url(string $name, string $extension): ?string {
    if (!pathOf("cgi.$name", $extension)) {
        throw new \RuntimeException("Unknown $name ($extension) in " . pathOf('cgi'));
    }
    return '/' . str_replace('.', '/', $name) . $extension;
}