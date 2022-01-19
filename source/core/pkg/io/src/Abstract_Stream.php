<?php namespace Ske\IO;

abstract class Abstract_Stream implements Stream_Interface {
    public function __construct($stream) {
        $this->setStream($stream);
    }

    public function __destruct() {
        fclose($this->getStream());
    }
}
