<?php namespace SIKessEm\UI\Request;

abstract class Abstract_URI implements URI_Interface {

  public function __construct(string $address) {
    
    $this->setAddress($address);
  }
}