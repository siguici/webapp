<?php namespace Ske\Util\InputVar;

class InputServer extends InputVar {
    public function __construct() {
        parent::__construct(INPUT_SERVER, &$_SERVER);
    }
}
