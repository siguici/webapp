<?php

$organizer = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

require (fn() => dirname(__DIR__) . '/bundle/src/main/cgi/' . ($path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: basename(__FILE__)) . '.php')();
