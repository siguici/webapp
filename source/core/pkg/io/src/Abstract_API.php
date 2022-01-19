<?php namespace Ske\IO;

abstract class Abstract_API implements API_Interface {
    public function __construct(Input_Interface $input, Output_Interface $output) {
        $this->setInput($input);
        $this->setOutput($output);
    }
}
