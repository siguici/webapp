<?php

$env_path = ENV_DIRECTORY . DIRECTORY_SEPARATOR . ENV_FILE;
if (!is_file($env_path))
    touch($env_path);

$env_data = file_get_contents($env_path);
$env = parse_ini_file($env_path, true, INI_SCANNER_TYPED);

$command = array_shift($argv);
--$argc;
if ($argc > 1) {
    $action = array_shift($argv);
    --$argc;
    switch ($action) {
        case 'put':
            if ($argc < 1) {
                fwrite(STDERR, 'Please provide the environment variable name' . PHP_EOL);
                exit(1);
            }
            $name = array_shift($argv);
            --$argc;
            $section = null;
            if (preg_match('/^(?P<name>[^=]+)=(?P<value>[^=]+)$/', $name, $matches)) {
                $name = $matches['name'];
                $value = $matches['value'];
                if (isset($argv[3]))
                    $section = $argv[3];
            }
            else if (isset($argv[3])) {
                $value = $argv[3];
                if (isset($argv[4]))
                    $section = $argv[4];
            }
            else {
                fwrite(STDERR, 'Please provide the environment variable value' . PHP_EOL);
                exit(1);
            }
            isset($section) ? $env[$section][$name] = $value : $env[$name] = $value;
            break;
        case 'get':
        if ($argc > 1) {
            if (preg_match('/(?P<section>[^:]+):(?P<name>[^=])=(?P<value>)/', $argv[1], $args)) {
                extract($args, EXTR_OVERWRITE);
            }

        }
            break;
    }
}
else {
    print $env_data .  PHP_EOL;
}
