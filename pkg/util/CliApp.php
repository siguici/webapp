<?php namespace Ske\Util;

class CliApp extends Command {
    public function __construct(string $root, string $name, string $description, string $usage, string $version = '0.0.0') {
        parent::__construct($name, $description, $usage);
        $this->setRoot($root);
        $this->setVersion($version);
    }

    protected string $root;

    public function setRoot(string $root) {
        $this->root = $root;
    }

    public function getRoot() {
        return $this->root;
    }

    protected string $version;

    public function setVersion(string $version) {
        $this->version = $version;
    }

    public function getVersion() {
        return $this->version;
    }

    public function execute(int $argc, array $argv) {
        if (PHP_SAPI !== 'cli' && PHP_SAPI !== 'phpdbg') {
            fwrite(STDERR, 'This script must be run from the command line.' . PHP_EOL);
            exit(1);
        }

        if (0 === $argc) {
            throw new \InvalidArgumentException('No command specified');
        }

        if (1 === $argc) {
            fwrite(STDOUT, $this->home() . PHP_EOL);
            exit;
        }

        if (2 > $argc) {
            fwrite(STDERR, $this->help() . PHP_EOL);
            exit(1);
        }

        $command = array_shift($argv);
        $argc--;


        if (!is_file($file  = __DIR__ . "/app/src/cli/{$command['name']}.php")) {
            fwrite(STDERR, 'Command not found: ' . $command['name'] . PHP_EOL);
            exit(1);
        }
    }
}