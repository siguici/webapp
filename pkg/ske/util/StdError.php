<?php namespace Ske\Util;

class StdError extends OutputStream {
	public function __construct() {
		parent::__construct(fopen('php://stderr', 'w'));
	}
}
