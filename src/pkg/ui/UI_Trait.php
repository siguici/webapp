<?php namespace SIKessEm\IO;

trait UI_Trait {

  use API_trait;

  protected Authority_Interface $authority;

  public function setAuthority(Authority_Interface $authority): Authority_Interface {

    return $this->authority = $authority;
  }

  public function getAuthority(): Authority_Interface {

    return $this->authority;
  }
}