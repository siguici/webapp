<?php namespace Ske\Util;

class StdInput extends InputStream {
	public function __construct() {
		parent::__construct(fopen('php://stdin', 'r'));
	}
}
