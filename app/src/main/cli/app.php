<?php

use Ske\Util\Dotignore;

$dotignore = new Dotignore([
    '/.git/',
    '/.idea/',
    '/vendor/',
    '/node_modules/',
    '/bower_components/',
    '/build/',
    '/dist/',
    '/tests/',
    '/tmp/',
    '/logs/',
    '/cache/',
    '/config/*',
    '.gitignore',
    '!/config/.gitmodules',
    '.editorconfig',
]);

$toIgnore = [
    '.gitignore',
    '/.git',
    '/config/.gitmodules/koffi',
    '/vendor',
];

$ignored = [];

foreach ($toIgnore as $file) {
    if (!$dotignore->isIgnored($file)) {
        fwrite(STDOUT, "$file is not ignored" . PHP_EOL);
    }
    else {
        fwrite(STDOUT, "$file is ignored" . PHP_EOL);
        $ignored[] = $file;
    }
}

if (($countIgnored = count($ignored)) !== ($countToIgnore = count($toIgnore))) {
    fprintf(
        STDERR,
        'Some files (%d/%d) are not ignored' . PHP_EOL,
        $countToIgnore - $countIgnored,
        $countToIgnore
    );
    exit(1);
}
exit(0);
$c = 1;
for ($i = 0; $i <= 97; $i++) {
    $j = $i + 10;
    echo PHP_EOL;
    echo "Start $i" . PHP_EOL;
    echo "\033[{$i}m$i \033[0m" . PHP_EOL;
    echo "\033[{$j}m$j \033[0m" . PHP_EOL;
    echo "End $j" . PHP_EOL;
    echo PHP_EOL;
}
echo str_repeat("\007", $c);
