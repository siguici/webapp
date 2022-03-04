<?php namespace Ske\Util;

class Std {
	public function __construct(?InputStream $in = null, ?OutputStream $out = null, ?OutputStream $err = null) {
		$this->in = $in ?? new InputStream();
		$this->out = $out ?? new OutputStream();
		$this->err = $err ?? new OutputStream();
	}

	public InputStream $in;
	public OutputStream $out;
	public OutputStream $err;

	public function __destruct() {
		$this->in->close();
		$this->out->close();
		$this->err->close();
	}
}
