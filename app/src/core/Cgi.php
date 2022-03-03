<?php namespace App;

use Ske\Cgi\App as SkeCgiApp;
use Ske\Util\Env;

class Cgi extends SkeCgiApp {
	public function __construct(string $name, array|Env $env) {
		parent::__construct($name, dirname(__DIR__) . '/main/cgi', $env);
	}

	public function init() {

	}
}
