<?php namespace App;

class Cli extends Ske\Cli\App
	public function __construct(array|Env $env) {
		parent::__construct(dirname(__DIR__) . '/main/cli'), $env);
	}
}
