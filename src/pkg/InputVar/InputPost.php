<?php namespace Ske\Util\InputVar;

class InputPost extends InputVar {
    public function __construct() {
        parent::__construct(INPUT_POST, &$_POST);
    }
}
