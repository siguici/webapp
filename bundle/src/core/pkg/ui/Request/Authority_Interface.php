<?php namespace SIKessEm\UI\Request;

interface Authority_Interface {

  public function setHost(string $host): string;

  public function getHost(): ?string;

  public function setPort(int $port): int;

  public function getPort(): ?int;

  public function setUsername(string $username): string;

  public function getUsername(): ?string;

  public function setPassword(string $password): string;

  public function getPassword(): ?string;
}