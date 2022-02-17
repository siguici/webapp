<?php

use Ske\Util\Env;

$command = parse_cmd($argc, $argv);
$__options = $command['options'];

$__env = new Env($command['args']);
$__env_file = $__options['name'] ?? $__options['n'] ?? '.env';
if (is_bool($__env_file)) {
    throw new \RuntimeException('Missing file name');
}

$__env_mode = $__options['mode'] ?? $__options['m'] ?? 'dev';
if (is_bool($__env_mode)) {
    throw new \RuntimeException('Missing mode name');
}

$__force = $__options['force'] ?? $__options['f'] ?? false;

$__dotenv_file = getcwd() . DIRECTORY_SEPARATOR . $__env_file;

if (is_file($__dotenv_file) && !$__force) {
    return parse_ini_file($__dotenv_file, true, INI_SCANNER_TYPED);
}

print "Writing $__dotenv_file ... " . PHP_EOL;

$__env_tpl_file = dirname(__DIR__) . '/cfg/env.tpl';
if (!is_file($__env_tpl_file)) {
    throw new \RuntimeException("Missing env template file ($__env_tpl_file)");
}

$__env_cfg_file = dirname(__DIR__) . '/cfg/env.php';
if (!is_file($__env_cfg_file)) {
    throw new \RuntimeException("Missing env configuration file ($__env_cfg_file)");
}

$__env_cfg = require $__env_cfg_file;
if (!is_array($__env_cfg)) {
    throw new \RuntimeException("Invalid env configuration file ($__env_cfg_file)");
}

foreach ($__env_cfg as $__key => $__value) {
    if (is_int($__key)) {
        $__key = $__value;
        $__value = null;
    }
    $__value = $__env[$__key] ?? $__value;
    while (!isset($__value)) {
        $__value = readline(ucfirst(str_replace('_', ' ', $__key)) . ': ');
    }
    $__env_cfg[$__key] = $__value;
}

$__env_tpl = file_get_contents($__env_tpl_file);
if (
    preg_match_all('/\$\{([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\}/', $__env_tpl, $__env_tpl_vars) ||
    preg_match_all('/\$([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $__env_tpl, $__env_tpl_vars)
) {
    foreach ($__env_tpl_vars[1] as $__env_tpl_var_key => $__env_tpl_var_name) {
        if (!isset($__env_cfg[$__env_tpl_var_name])) {
            throw new \RuntimeException("Missing env configuration variable ($__env_tpl_var_name)");
        }
        $__env_tpl = str_replace($__env_tpl_vars[0][$__env_tpl_var_key], $__env_cfg[$__env_tpl_var_name], $__env_tpl);
    }
}

file_put_contents($__dotenv_file, $__env_tpl);

print "Done." . PHP_EOL;

return parse_ini_string($__env_tpl, true, INI_SCANNER_TYPED);
