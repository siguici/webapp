<?php namespace Ske\Bundle;

class RequestParser implements OrderParser {
    public function __construct(string $method, string $url) {
		$this->method = $method;
		$this->url = $url;
	}

	public function getName(): string|false {
		$path = parse_url($this->url, PHP_URL_PATH);
		$path = trim($path, '/');
		if (empty($path)) {
			if (empty($this->method)) {
				return false;
			}
			else {
				$name = $this->method;
				$this->method = '';
			}
		}
		else {
			$path = explode('/', $path);
			$name = array_shift($path);
			$this->url = implode('/', $path);
		}
	}

}
