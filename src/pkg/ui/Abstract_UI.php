<?php namespace SIKessEm\IO;

class Abstract_UI extends API implements UI_Interface {

  public function __construct() {

    parent::__construct(
      new Input(fopen('php://input', 'r')),
      new Output(fopen('php://output', 'w'))
    );
  }
}