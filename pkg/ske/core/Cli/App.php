<?php namespace Ske\Cli;

use Ske\App as SkeApp;
use Ske\Util\Env;

abstract class App extends SkeApp {
	public function __construct(string $name, string $dir, array|Env $env) {
		parent::__construct('cli', $name, $dir, $env, fopen('php://stdin', 'r'), fopen('php://stdout', 'w'), fopen('php://stderr', 'w'));
	}

	final public function run(array $args): void {
		if ('cli' !== PHP_SAPI && 'phpdbg' !== PHP_SAPI) {
			throw new \RuntimeException('This application can only be run from the command line.');
		}

		$argc = $args['argc'] ??= $_SERVER['argc'] ??= 0;
		$argv = $args['argv'] ??= $_SERVER['argv'] ??= [];

		$this->execute($argc, $argv);
	}

	protected function execute(int $argc, array $argv): void {
		if ($argc !== count($argv)) {
			throw new \InvalidArgumentCountException('Wrong number of arguments.');
		}

		if (0 === $argc) {
			return;
		}

		if (realpath($argv[0]) === realpath($this->getName())) {
			$this->executeCommand(--$argc, array_slice($argv, 1));
			return;
		}

		if (file_exists($path = $argv[0]) || file_exists($path = $this->getDir() . DIRECTORY_SEPARATOR . $argv[0])) {
			$this->executePath($path, $argc, $argv);
			return;
		}

		if (is_file($file = $this->getDir() . DIRECTORY_SEPARATOR . $argv[0] . '.php')) {
			$this->executeScript($file, $argc, $argv);
			return;
		}

		$this->error->writeLine("Command '$name' not found.");
	}

	protected function executeCommand(int $argc, array $argv): void {
		if (0 === $argc) {
			return;
		}

		foreach ($this->todo() as $command => $action) {
			if (fnmatch($command, $argv[0])) {
				$action($argc, $argv);
				return;
			}
		}
	}

	protected function executePath(string $path, int $argc, array $argv): void {
		$path = realpath($path);
		is_dir($path) ? $this->executeDirectory($path, $argc, $argv) : $this->executeFile($path, $argc, $argv);
	}

	protected function executeDirectory(string $dir, int $argc, array $argv): void {
		$this->dir = $dir;
		$this->execute($argc, $argv);
	}

	protected function executeFile(string $file, int $argc, array $argv): void {
		$this->executeBinary(PHP_BINARY, [$file, ...$argv]);
	}

	protected function executeBinary(string $binary, array $args): void {
		$args = array_map(fn($arg) => escapeshellarg($arg), $args);
		$cmd = implode(' ', $args);
		exec("$binary $cmd", $output, $status);
		foreach ($output as $line) {
			0 === $status ? $this->output->writeLine($line) : $this->error->writeLine($line);
		}
		exit($status);
	}

	public function executeScript(string $file, int $argc, array $argv): void {
		require $file;
	}
}
