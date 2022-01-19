<?php namespace Ske\IO;

trait Stream_Trait {
    protected $stream;

    public function setStream($stream) {
        if(!is_resource($stream))
            throw new Error('Cannot use ' . gettype($stream) . ' as stream', Error::INVALID_STREAM);
        return $this->stream = $stream;
    }

    public function getStream() {
        return $this->stream;
    }
}
