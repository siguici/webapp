<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Method implements Method_Interface {

  public function __construct(string $verb) {
    
    $this->setVerb($verb);
  }
}
