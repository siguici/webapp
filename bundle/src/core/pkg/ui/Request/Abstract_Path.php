<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Path implements Path_Interface {

  public function __construct(string $name) {
    
    $this->setName($name);
  }
}
