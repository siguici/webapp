<?php namespace Ske\Cmd;

class Exception extends \InvalidArgumentException {
    const WRONG_COUNT = 0x01;
    const INVALID_VALUE = 0x02;
    const OVERFLOW_INDEX = 0x03;
}
