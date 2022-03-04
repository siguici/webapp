<?php namespace Ske\Bundle;

class CommandParser implements OrderParser {
    public function __construct(int $argc, array $argv) {
		$this->argc = $argc;
		$this->argv = $argv;
	}

	public function getName(): string|false {
		if ($this->argc < 1) {
			return false;
		}
		$name = $this->argv[0];
		if (0 === strpos($name, '-')) {
			return false;
		}
		array_shift($this->argv);
		--$this->argc;
		return $name;
	}

	public function getData(): array {
		return ['argc' => $this->argc, 'argv' => $this->argv];
	}
}
