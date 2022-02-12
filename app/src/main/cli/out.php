<?php

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
