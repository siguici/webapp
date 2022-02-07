<?php namespace Ske\Util\InputVar;

class InputCookie extends InputVar {
    public function __construct() {
        parent::__construct(INPUT_COOKIE, &$_COOKIE);
    }
}
