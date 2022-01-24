<?php
const APP_ROOT = __DIR__;
const ENV_FILE = 'env.ini';

$organizer = require_once __DIR__ . '/bundle/src/core/pkg/organizer/bootstrap.php';
return $organizer->organize(__DIR__);
