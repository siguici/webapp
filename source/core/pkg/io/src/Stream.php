<?php namespace Ske\IO;

trait Stream {
    protected $stream;
    
    public function __construct($stream) {
        $this->setStream($stream);
    }

    public function setStream($stream) {
        if(!is_resource($stream))
            throw new Exception('Cannot use ' . gettype($stream) . ' as stream', Exception::INVALID_STREAM);
        return $this->stream = $stream;
    }

    public function getStream() {
        return $this->stream;
    }

    public function __destruct() {
        fclose($this->getStream());
    }
}
