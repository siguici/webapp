<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Query implements Query_Interface {
  
  public function __construct(string $string) {
    
    $this->setString($string);
  }
}