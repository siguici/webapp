<?php namespace Ske\Util;

class Application {
	use StdStreams;

	public function __construct(string $name, string $dir, array|Env $env = [], ?Input $inputStream = null, ?Output $outputStream = null, ?Output $errorStream = null) {
		$this->setName($name);
		$this->setDir($dir);
		$this->setEnv($env);
		$this->setInputStream($inputStream);
		$this->setOutputStream($outputStream);
		$this->setErrorStream($errorStream);
	}

	protected string $name;

	public function setName(string $name) {
		if (empty($name)) {
			throw new \InvalidArgumentException('Name cannot be empty');
		}
		$this->name = $name;
	}

	public function getName(): string {
		return $this->name;
	}

	protected string $dir;

	public function setDir(string $dir): self {
		if (empty($dir)) {
			throw new \InvalidArgumentException('Directory cannot be empty');
		}

		if (!is_dir($dir)) {
			throw new \InvalidArgumentException("$dir is not a directory");
		}

		if (!is_readable($dir)) {
			throw new \InvalidArgumentException("$dir is not readable");
		}

		$this->dir = realpath($dir);
		return $this;
	}

	public function getDir(): string {
		return $this->dir;
	}

	protected Env $env;

	public function setEnv(array|Env $env): self {
		if ($env instanceof Env) {
			$this->env = $env;
		}
		else {
			$this->env = new Env($env);
		}
		return $this;
	}

	public function getEnv(): Env {
		return $this->env;
	}

	public function run(array $args): Result {
		if ('cli' === PHP_SAPI || 'phpdbg' === PHP_SAPI) {
			$this->getInputStream()->open('php://stdin', 'r');
			$this->getOutputStream()->open('php://stdout', 'w');
			$this->getErrorStream()->open('php://stderr', 'w');

			$argc = $args['argc'] ??= $_SERVER['argc'] ??= 0;
			$argv = $args['argv'] ??= $_SERVER['argv'] ??= [];

			if (0 === $argc) {
				return new Result(0);
			}

			$name = basename($argv[0]);
			if ($name === $this->getName()) {
				array_shift($argv);
				--$argc;
			}

			return $this->processCommand($name, $argc, $argv);
		}
		else {
			$this->getInputStream()->open('php://input', 'r');
			$this->getOutputStream()->open('php://output', 'w');
			$this->getErrorStream()->open('php://output', 'w');

			$name = $args['SERVER_NAME'] ??= $_SERVER['SERVER_NAME'] ??= 'localhost';
			$host = $args['HTTP_HOST'] ??= $_SERVER['HTTP_HOST'] ??= '127.0.0.1';
			$port = $args['SERVER_PORT'] ??= $_SERVER['SERVER_PORT'] ??= 80;
			$username = $args['PHP_AUTH_USER'] ??= $_SERVER['PHP_AUTH_USER'] ??= '';
			$password = $args['PHP_AUTH_PW'] ??= $_SERVER['PHP_AUTH_PW'] ??= '';
			$scheme = $args['REQUEST_SCHEME'] ??= $_SERVER['REQUEST_SCHEME'] ??= 'http';
			$method = $args['REQUEST_METHOD'] ??= $_SERVER['REQUEST_METHOD'] ??= 'GET';
			$uri = $args['REQUEST_URI'] ??= $_SERVER['REQUEST_URI'] ??= '/';

			$url = $scheme . '://' . ($username ? $username . ':' . $password . '@' : '') . $host . ($port ? ':' . $port : '') . $uri;
			return $this->processRequest($name, $method, $url);
		}
		return new Result(0, $message);
	}

	public function processCommand(string $name, int $argc, array $argv): Result {
		return new Result(0, "Command $name is running in CLI mode with $argc arguments: " . implode(' ', $argv) . PHP_EOL);
	}

	public function processRequest(string $name, string $method, string $url): Result {
		return new Result(0, "<p>Request $name is running in CGI mode with HTTP $method to $url</p>");
	}

	public function write(Result $result): int|false {
		return $result->isSuccess() ?
			$this->getOutputStream()->write($result->getMessage()) :
			$this->getErrorStream()->write($result->getMessage());
	}

	public function send(Result $result): void {
		$this->write($result);
		exit($result->getStatus());
	}

	public function __destruct() {
		$this->getInputStream()->close();
		$this->getOutputStream()->close();
		$this->getErrorStream()->close();
	}
}
