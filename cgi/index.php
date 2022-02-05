<?php

$organizer = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: 'home';
if (
    !is_file($file = dirname(__DIR__) . "/src/app/cgi/$path.php") &&
    !is_file($file = dirname(__DIR__) . "/src/app/cgi/$path/{$_SERVER['REQUEST_METHOD']}.php")
) {
    http_response_code(404);
    echo "Document $path not found";
    exit(1);
}
require $file;
