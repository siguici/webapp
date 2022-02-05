<?php

use Composer\Autoload\ClassLoader as ComposerAutoloader;

function get_composer_autoloader(string $root = __DIR__): ?ComposerAutoloader {
    $composer_autoloader = null;
    while (!isset($composer_autoloader) && dirname($root) !== $root) {
        if (is_file($composer_file = $root . DIRECTORY_SEPARATOR . 'composer.json') && is_readable($composer_file)) {
            if (($composer_data = @file_get_contents($composer_file)) && ($composer_data = @json_decode($composer_data, true))) {
                if (is_file($autoload_file = $root . DIRECTORY_SEPARATOR . ($composer_data['config']['vendor-dir'] ?? 'vendor') . DIRECTORY_SEPARATOR . 'autoload.php') && is_readable($autoload_file)) {
                    $composer_autoloader = require_once $autoload_file;
                }
                unset($autoload_file);
            }
            unset($composer_data);
        }
        unset($composer_file);
        $root = dirname($root);
    }
    unset($root);
    return $composer_autoloader;
}

function env(string $name, mixed $value = null): mixed {
    $env = getenv($name) ?? $_ENV[$name] ?? $_SERVER[$name] ?? null;
    return match (true) {
        !isset($env) => $value,
        in_array($env, ['null', 'nil', 'none']) => null,
        in_array($env, ['true', 'on', 'yes']) => true,
        in_array($env, ['false', 'off', 'no']) => false,
        is_numeric($env) => is_int(strpos($env, '.')) ? (float) $env : (int) $env,
        default => $env,
    };
}
