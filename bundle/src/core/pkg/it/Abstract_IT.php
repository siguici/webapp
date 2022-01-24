<?php namespace SIKessEm\IO;

class Abstract_IT extends API implements IT_Interface {

  public function __construct() {

    parent::__construct(
      new Authority($_SERVER['SERVER_ADDR'], $_SERVER['SERVER_PORT']),
      new Input(STDIN),
      new Output(STDERR)
    );
  }
}