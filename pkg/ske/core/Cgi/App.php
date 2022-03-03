<?php namespace Ske\Cgi;

use Ske\App as SkeApp;
use Ske\Util\Env;

abstract class App extends SkeApp {
	public function __construct(string $name, string $dir, array|Env $env) {
		parent::__construct('cgi', $name, $dir, $env, fopen('php://input', 'r'), fopen('php://output', 'w'), fopen('php://output', 'w'));
	}

	final public function run(array $args): void {
		$name = $args['SERVER_NAME'] ??= $_SERVER['SERVER_NAME'] ??= $this->getName();
		$server = $args['HTTP_HOST'] ??= $_SERVER['HTTP_HOST'] ??= 'localhost';
		$host = $args['SERVER_ADDR'] ??= $_SERVER['SERVER_ADDR'] ??= '127.0.0.1';
		$port = $args['SERVER_PORT'] ??= $_SERVER['SERVER_PORT'] ??= 80;
		$username = $args['PHP_AUTH_USER'] ??= $_SERVER['PHP_AUTH_USER'] ??= '';
		$password = $args['PHP_AUTH_PW'] ??= $_SERVER['PHP_AUTH_PW'] ??= '';
		$scheme = $args['REQUEST_SCHEME'] ??= $_SERVER['REQUEST_SCHEME'] ??= 'http';
		$method = $args['REQUEST_METHOD'] ??= $_SERVER['REQUEST_METHOD'] ??= 'GET';
		$uri = $args['REQUEST_URI'] ??= $_SERVER['REQUEST_URI'] ??= '/';
		$uri = preg_replace('/\/+/', '/', $uri);
		$uri = trim($uri, '/');

		preg_match("/^(?P<base>(?:[^.]+\.)*)(?P<name>{$name})$/", $server, $matches);
		$base = $matches['base'] ??= '';
		$base = str_replace('.', '/', $base);
		$base = '/' . $base;

		$url = $scheme . '://' . ($username ? $username . ':' . $password . '@' : '') . $host . ($port ? ':' . $port : '') . $base . $uri;
		$this->error->write("Hello World from $url");
	}
}
