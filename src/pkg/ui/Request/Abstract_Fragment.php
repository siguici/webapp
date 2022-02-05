<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Fragment implements Fragment_Interface {

  public function __construct(string $anchor) {
    
    $this->setAnchor($anchor);
  }
}
