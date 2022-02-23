<?php namespace Ske\Util;

class RequestParser implements OrderParser {
    public function __construct(string $method, string $url) {
		$this->method = $method;
		$this->url = $url;
	}

	public function parse(): void {
		//...
	}

    public function parsed(): bool {
        return true;
    }

	public function execute(): Result {
		return new Result(0, "<p>Request is running in CGI mode with HTTP $this->method to $this->url</p>");
	}
}
