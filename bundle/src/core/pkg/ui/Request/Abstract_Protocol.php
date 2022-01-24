<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Protocol implements Protocol_Interface {

  public function __construct(string $scheme, bool $secure) {
    
    $this->setScheme($scheme);
    $this->setSecure($secure);
  }
}
