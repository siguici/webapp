<?php namespace Ske\Util;

class CommandParser implements OrderParser {
    public function __construct(int $argc, array $argv) {
		$this->argc = $argc;
		$this->argv = $argv;
	}

	public function parse(): void {
		//...
	}

    public function parsed(): bool {
        return true;
    }

	public function execute(): Result {
		return new Result(0, "Command running in CLI mode with $this->argc arguments: " . implode(' ', $this->argv) . PHP_EOL);
	}
}
