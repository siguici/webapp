<?php

use Ske\Util\{Env, Template};

$command = parse_cmd($argc, $argv);
$options = $command['options'];

$env = new Env($command['args']);
$env_file = $options['name'] ?? $options['n'] ?? '.env';
if (is_bool($env_file)) {
    throw new \RuntimeException('Missing file name');
}

$env_mode = $options['mode'] ?? $options['m'] ?? 'dev';
if (is_bool($env_mode)) {
    throw new \RuntimeException('Missing mode name');
}

$force = $options['force'] ?? $options['f'] ?? false;

$dotenv_file = getcwd() . DIRECTORY_SEPARATOR . $env_file;

if (is_file($dotenv_file) && !$force) {
    return parse_ini_file($dotenv_file, true, INI_SCANNER_TYPED);
}

print "Writing $dotenv_file ... " . PHP_EOL;

$env_tpl_file = dirname(__DIR__) . '/cfg/env.tpl';
if (!is_file($env_tpl_file)) {
    throw new \RuntimeException("Missing env template file ($env_tpl_file)");
}

$env_cfg_file = dirname(__DIR__) . '/cfg/env.php';
if (!is_file($env_cfg_file)) {
    throw new \RuntimeException("Missing env configuration file ($env_cfg_file)");
}

$env_cfg = require $env_cfg_file;
if (!is_array($env_cfg)) {
    throw new \RuntimeException("Invalid env configuration file ($env_cfg_file)");
}

foreach ($env_cfg as $key => $value) {
    if (is_int($key)) {
        $key = $value;
        $value = null;
    }
    $value = $env[$key] ?? $value;
    while (!isset($value)) {
        $value = readline(ucfirst(str_replace('_', ' ', $key)) . ': ');
    }
    $env_cfg[$key] = $value;
}

$template = new Template($env_tpl_file, $env_cfg);
$template->save($dotenv_file);

print "Done." . PHP_EOL;

return parse_ini_file($env_tpl_file, true, INI_SCANNER_TYPED);
