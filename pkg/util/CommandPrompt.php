<?php namespace Ske\Util;

class CommandPrompt {
    use FileSystem;

    public function __construct(string $pwd, protected $input = STDIN, protected $output = STDOUT, protected $error = STDERR) {
        $this->cd($pwd);
    }

    public function run(int $argc, array $argv): void {
        if ($argc !== count($argv)) {
            throw new \UnexectedArgumentCountException('Unexpected argument count');
        }
        if (0 === $argc) {
            return;
        }
        $command = array_shift($argv);
        $this->execute($command, $argv);
    }

    protected function execute(string $command, array $argv): void {
        $command = $this->resolveCommand($command);
        $this->executeCommand($command, $argv);
    }

    protected function resolveCommand(string $command): string {
        $command = $this->resolveAlias($command);
        $command = $this->resolvePath($command);
        return $command;
    }

    protected function resolveAlias(string $command): string {
        $aliases = $this->getAliases();
        if (isset($aliases[$command])) {
            $command = $aliases[$command];
        }
        return $command;
    }

    protected function resolvePath(string $command): string {
        $path = $this->getPath();
        if (file_exists($path . $command)) {
            $command = $path . $command;
        }
        return $command;
    }

    protected function executeCommand(string $command, array $argv): void {
        $command = $this->resolveCommand($command);
        $argv = $this->resolveArguments($argv);
        $this->execute($command, $argv);
    }

    protected function resolveArguments(array $argv): array {
        $argv = array_map(function($arg) {
            return escapeshellarg($arg);
        }, $argv);
        return $argv;
    }
}