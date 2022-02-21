<?php namespace Ske\Util;

class CommandPrompt {
    use FileSystem;

    public function __construct(string $pwd, protected $input = STDIN, protected $output = STDOUT, protected $error = STDERR) {
        $this->cd($pwd);
    }

    public function input() {
        return $this->input;
    }

    public function output() {
        return $this->output;
    }

    public function error() {
        return $this->error;
    }

    public function run(int $argc, array $argv, ): void {
        if ($argc !== count($argv)) {
            throw new \UnexpectedArgumentCountException('Unexpected argument count');
        }
        if (0 === $argc) {
            return;
        }
        $this->processFile($argv[0] . '.php', $argc, $argv);
    }

    protected function processFile(string $file, int $argc, array $argv): void {
        $file = $this->resolvePath($file);
        if (\is_dir($file)) {
            $this->cd($file);
            $this->run($argc, $argv);
            return;
        }
        if (\is_readable($file)) {
            require $file;
            return;
        }
        $this->executeFile($file, $argc, $argv);
    }

    protected function resolvePath($file): string {
        return file_exists($file) ? realpath($file) : $this->pwd() . DIRECTORY_SEPARATOR . $file;
    }


    protected function executeFile(string $file, int $argc, array $argv): void {
        array_slice($argv, 0, $argc);
        $this->executeCommand([
            PHP_BINARY,
            $file,
            ...array_map(fn($arg) => escapeshellarg($arg), $argv)
        ]);
    }

    protected function executeCommand(array $args): void {
        exec(implode(' ', $args), $output, $return);
        $std = $return === 0 ? $this->output() : $this->error();
        fwrite($std, implode(PHP_EOL, $output));
        exit($return);
    }
}