<?php namespace Ske\Util;

class Stream {
    protected $stream;

    public function __construct($stream) {
        $this->setStream($stream);
    }

    public function setStream($stream) {
        if(!\is_resource($stream))
            throw new StreamException('Cannot use ' . gettype($stream) . ' as stream', Exception::INVALID_STREAM);
        return $this->stream = $stream;
    }

    public function open($stream, string $mode) {
		$this->setStream(\fopen($stream, $mode));
	}

    public function getStream() {
        return $this->stream;
    }

    public function close(): void {
		if(\is_resource($this->getStream()))
			\fclose($this->getStream());
	}

    public function __destruct() {
		$this->close();
    }
}
