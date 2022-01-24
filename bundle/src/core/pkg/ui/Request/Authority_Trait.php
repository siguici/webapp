<?php namespace SIKessEm\UI\Request;

trait Authority_Trait {

  protected ?string $host = null;

  public function setHost(string $host): string {

    return $this->host = $host;
  }

  public function getHost(): ?string {

    return $this->host;
  }

  protected ?int $port = null;

  public function setPort(int $port): int {

    return $this->port = $port;
  }

  public function getPort(): ?int {

    return $this->port;
  }

  protected ?string $username = null;

  public function setUsername(string $username): string {

    return $this->username = $username;
  }

  public function getUsername(): ?string {

    return $this->username;
  }

  protected ?string $password = null;

  public function setPassword(string $password): string {

    return $this->password = $password;
  }

  public function getPassword(): ?string {

    return $this->password;
  }
}