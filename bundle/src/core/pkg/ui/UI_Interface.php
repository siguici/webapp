<?php namespace SIKessEm\IO;

interface UI_Interface extends API_Interface {

  public function setAuthority(Authority_Interface $authority): Authority_Interface;

  public function getAuthority(): Authority_Interface;
}