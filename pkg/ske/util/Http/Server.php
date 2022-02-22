<?php namespace Ske\Util\Http;

class Server {
    public function __construct(string $root, string $host, int $port) {
        if (!is_dir($root)) {
            throw new \Exception("$root is not a directory");
        }
        if (!is_readable($root)) {
            throw new \Exception("$root is not readable");
        }
        $this->root = realpath($root) . DIRECTORY_SEPARATOR;
		$this->host = $host;
		$this->port = $port;
    }

    public function process(array $env): void {
    	die(print_r($env, true));

        $path = trim(parse_url($env['REQUEST_URI'], PHP_URL_PATH), '/') ?: 'home';
        if (
            !($file = $this->pathOf("app.src.main.cgi.$path")) &&
            !($file = $this->pathOf("app.src.main.cgi.$path{$env['REQUEST_METHOD']}"))
        ) {
            http_response_code(404);
            echo "Document $path not found";
            exit(1);
        }
        require $file;
    }
}
