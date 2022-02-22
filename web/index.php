<?php

use Ske\Util\Application;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new Application(dirname(__DIR__) . '/app/src/main/cgi', env());

$result = $app->run($_SERVER);

$app->send($result);
