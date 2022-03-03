<?php namespace Ske;

use Ske\Util\{
	Env,
	EventEmitter,
	InputStream,
	OutputStream,
	ErrorStream
};

abstract class App {
	use EventEmitter;

	public function __construct(protected string $type, protected string $name, string $dir, array|Env $env, $input, $output, $error) {
		$this->setDir($dir);
		$this->setEnv($env);
		$this->setInput($input);
		$this->setOutput($output);
		$this->setError($error);
		$this->init();
	}

	public function getType(): string {
		return $this->type;
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
		$this->env = is_array($env) ? new Env($env) : $env;
		return $this;
	}

	public function getEnv(): Env {
		return $this->env;
	}

	protected InputStream $input;

	public function setInput($input) {
		$this->input = new InputStream($input);
	}

	public function getInput(): InputStream {
		return $this->input;
	}

	protected OutputStream $output;

	public function setOutput($output) {
		$this->output = new OutputStream($output);
	}

	public function getOutput(): OutputStream {
		return $this->output;
	}

	protected OutputStream $error;

	public function setError($error) {
		$this->error = new OutputStream($error);
	}

	public function getError(): OutputStream {
		return $this->error;
	}

	abstract protected function init();

	abstract public function run(array $args): void;
}
