<?php namespace App;

class Cgi extends Ske\Cgi\App
	public function __construct(array|Env $env) {
		parent::__construct(dirname(__DIR__) . '/main/cgi'), $env);
	}
}
