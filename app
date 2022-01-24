#!/usr/bin/env php
<?php

use Ske\Cli\Console;
use Ske\Cli\App;
use Ske\Cmd\Args;

$Organizer = require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

function colorLog($str, $type = 'i'){
    switch ($type) {
        case 'e': //error
            echo "\033[31m$str \033[0m\n";
        break;
        case 's': //success
            echo "\033[32m$str \033[0m\n";
        break;
        case 'w': //warning
            echo "\033[33m$str \033[0m\n";
        break;  
        case 'i': //info
            echo "\033[36m$str \033[0m\n";
        break;      
        default:
        # code...
        break;
    }
}

function format(array $format=[],string $text = '') {
  $codes=[
    'bold'=>1, 'italic'=>3, 'underline'=>4, 'strikethrough'=>9,
    'black'=>30, 'red'=>31, 'green'=>32, 'yellow'=>33,'blue'=>34, 'magenta'=>35, 'cyan'=>36, 'white'=>37,
    'blackbg'=>40, 'redbg'=>41, 'greenbg'=>42, 'yellowbg'=>44,'bluebg'=>44, 'magentabg'=>45, 'cyanbg'=>46, 'lightgreybg'=>47
  ];
  $formatMap = array_map(fn($v) => $codes[$v], $format);
  return "\e[".implode(';',$formatMap).'m'.$text."\e[0m";
}

function formatLn(array $format=[], string $text='') {
  return format($format, $text) . PHP_EOL;
}

// ::log method usage
// -------------------------------------------------------
Console::log('Im Red!', 'red');
Console::log('Im Blue on White!', 'white', true, 'blue');

Console::log('I dont have an EOF', false);
Console::log("\tThis is where I come in.", 'light_green');
Console::log('You can swap my variables', 'black', 'yellow');
Console::log(str_repeat('-', 60));

// Direct usage
// -------------------------------------------------------
echo Console::blue('Blue Text') . "\n";
echo Console::black('Black Text on Magenta Background', 'magenta') . "\n";
echo Console::red('Im supposed to be red, but Im reversed!', 'reverse') . "\n";
echo Console::red('I have an underline', 'underline') . "\n";
echo Console::blue('I should be blue on light gray but Im reversed too.', 'light_gray', 'reverse') . "\n";

// Ding!
// -------------------------------------------------------
echo Console::bell();

//Examples:
echo format(['blue', 'bold', 'italic','strikethrough'], "Wohoo");
echo formatLn(['yellow', 'italic'], " I'm invicible");
echo formatLn(['yellow', 'bold'], "I'm invicible");
echo Console::bell(2);
die(colorLog("SIGUI Kesse Emmanuel"));

$args = new Args($argc, $argv);
/*
$args->addArg('koffi');

echo "Count : {$args->count()}" . PHP_EOL;
print_r($args->values());

die($args->getArg(2));

$args->setFlag('app');
$args->parse();
if ($args->parsed())
    $arg = $args->getFlag('app');
*/
$app = new App();
$app->getOutput()->writeLine(colorLog('Welcome to SIKessEm!'));
