<?php namespace Ske\Util\InputVar;

class InputGet extends InputVar {
    public function __construct() {
        parent::__construct(INPUT_GET, &$_GET);
    }
}