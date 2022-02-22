<?php namespace Ske\Util;

class StdOutput extends OutputStream {
	public function __construct() {
		parent::__construct(fopen('php://stdout', 'w'));
	}
}
