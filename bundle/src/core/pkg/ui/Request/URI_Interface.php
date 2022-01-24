<?php namespace SIKessEm\UI\Request;

interface URI_Interface {

  public function setAddress(string $address): static;

  public function getProtocol(): Protocol_Interface;

  public function getAuthority(): Authority_Interface;

  public function getPath(): Path_Interface;

  public function getQuery(): Query_Interface;

  public function getFragment(): Fragment_Interface;
}