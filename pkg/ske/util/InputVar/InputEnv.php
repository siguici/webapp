<?php namespace Ske\Util\InputVar;

class InputEnv extends InputVar {
    public function __construct() {
        parent::__construct(INPUT_ENV, &$_ENV);
    }
}
