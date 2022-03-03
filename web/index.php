<?php

use App\Cgi as CgiApp;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new CgiApp($_SERVER['SERVER_NAME'], env());

$app->run($_SERVER);

