<?php

use SIKessEm\Organizer\SystemInterface as System;

function main(System $sys) {
    $settings = $sys->import('cfg.program');
    extract($settings);
}
