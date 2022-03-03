<?php namespace Ske\Cgi;

class App {
	public function __construct(string $dir, array|Env $env) {
		parent::__construct($dir, $env, fopen('php://input', 'r'), fopen('php://output', 'w'), fopen('php://output', 'w'));
	}
}
