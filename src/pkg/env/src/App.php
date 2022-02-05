<?php namespace Ske\Env;

use Ske\Cli\App as CliApp;

class App extends CliApp {
    public static function run (int $argc, array $argv): void {
        if ($argc <= 1)
            self::sendUsage($argv[0]);
    }

    public static function sendUsage(string $command): void {
        $usage = <<<EOF
Usage $command <file>

EOF;
        self::send($usage);
    }
    
    public static function write(string $output): void {
        
    }
    
    public static function read(): string {
        
    }
    
    public static function send(int|string|null $result = null): void {
        if (!isset($result))
            exit;
        exit($result);
    }
}
