<?php

use Ske\IO\{Input, Output};
use Ske\Cgi\{Server};

$organizer = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$env_type = trim(file_get_contents(APP_ROOT . DIRECTORY_SEPARATOR . ENV_TYPE));
$envs = parse_ini_file(APP_ROOT . DIRECTORY_SEPARATOR . ENV_FILE, true, INI_SCANNER_TYPED);
$env = $envs[$env_type];

$server = new Server($env['server.host'], $env['server.port']);
$website = $server->addDomain($env['server.name'], APP_ROOT . '/source/main/cgi', [
    '' => 'home'
]);
$website->addSubdomain('about');
$server->process($_SERVER, new Input(fopen('php://input', 'r')), new Output(fopen("php://output", "w")));
