<?php

$organizer = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: 'home'; 

require (fn() => dirname(__DIR__) . "/bundle/src/main/cgi/$path.php")();
