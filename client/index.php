<?php

use Ske\Web\Server;

$autoloader = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

$server = new Server($_SERVER['SERVER_NAME'], "{$autoloader->getDirectory()}server");

//$server->on('get', '/', fn() => 'Hello world');

$server->connect($_SERVER['HTTP_HOST']);

return $server->do($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_REQUEST);
