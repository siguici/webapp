<?php namespace SIKessEm\UI\Request;

abstract class Abstract_Authority implements Authority_Interface {

  public function __construct(?string $host, ?int $port, ?string $username = null, ?string $password = null) {

    if(isset($host)) $this->setHost($host);
    if(isset($port)) $this->setPort($port);
    if(isset($username)) $this->setUsername($username);
    if(isset($password)) $this->setPassword($password);
  }
}