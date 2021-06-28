<?php

use SIKessEm\Organizer\SystemInterface as System;

function main(System $sys) {
    $settings = $sys->import('cfg.program');
    extract($settings);
    echo 'Welcome to <a href="'. $home_url .'" title="Go to home">'. $app_name .'</a> !';
    exit;
}
