<?php namespace Ske\Util;

trait StdStreams {
	protected $inputStream;

	public function setInputStream(?Input $stream = null): Input {
		return $this->inputStream = $stream ??= new StdInput();
	}

	public function getInputStream(): Input {
		return $this->inputStream;
	}

	protected $outputStream;

	public function setOutputStream(?Output $stream): Output {
		return $this->outputStream = $stream ??= new StdOutput();
	}

	public function getOutputStream(): Output {
		return $this->outputStream;
	}

	protected $errorStream;

	public function setErrorStream(?Output $stream): Output {
		return $this->errorStream = $stream ??= new StdError();
	}

	public function getErrorStream(): Output {
		return $this->errorStream;
	}
}
