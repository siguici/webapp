<?php namespace Ske\Cli;

class App extends Ske\App {
	public function __construct(string $dir, array|Env $env) {
		parent::__construct($dir, $env, fopen('php://stdin', 'r'), fopen('php://stdout', 'w'), fopen('php://stderr', 'w'));
	}
}
