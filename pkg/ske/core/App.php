<?php namespace Ske;

abstract class App {
	public function __construct(string $dir, array|Env $env, $input, $output, $error) {
		$this->setDir($dir);
		$this->setEnv($env);
		$this->setInput($input);
		$this->setOutput($output);
		$this->setError($error);
	}

	protected \RecursiveDirectoryIterator $dir;

	public function setDir(string $dir) {
		$this->dir = new \RecursiveDirectoryIterator($dir);
	}

	public function getDir(): \RecursiveDirectoryIterator {
		return $this->dir;
	}

	protected Env $env;

	public function setEnv(array|Env $env) {
		$this->env = is_array($env) ? new Env($env) : $env;
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

	abstract public function run(array $args): void;
}
