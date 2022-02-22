<?php namespace Ske\Util;

class Application {
	use StdStreams;

	public function __construct(string $dir, array|Env $env = [], $inputStream = null, $outputStream = null, $errorStream = null) {
		$this->setDir($dir);
		$this->setEnv($env);
		$this->setInputStream($inputStream);
		$this->setOutputStream($outputStream);
		$this->setErrorStream($errorStream);
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
			$message = 'Run from command line' . PHP_EOL;
		}
		else {
			$message = 'Run from web <br/>';
		}
		return new Result(0, $message);
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
		$this->closeInputStream();
		$this->closeOutputStream();
		$this->closeErrorStream();
	}
}
