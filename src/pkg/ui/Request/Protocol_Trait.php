<?php namespace SIKessEm\UI\Request;

trait Protocol_Trait {

  protected string $scheme;

  public function setScheme(string $scheme): string {

    return $this->scheme = $scheme;
  }

  public function getScheme(): string {

    return $this->scheme;
  }

  protected bool $secure;

  public function setSecure(bool $secure): bool {

    return $this->secure = $secure;
  }

  public function getSecure(): bool {

    return $this->secure;
  }
}
