<?php namespace App;

use Ske\Cli\App as SkeCliApp;
use Ske\Util\Env;

class Cli extends SkeCliApp {
	public function __construct(string $name, array|Env $env) {
		parent::__construct($name, dirname(__DIR__) . '/main/cli', $env);
	}

	public function init() {

	}
}
