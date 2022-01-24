<?php namespace SIKessEm\UI\Request;

interface Protocol_Interface {

  public function setScheme(string $scheme): string;

  public function getScheme(): string;

  public function setSecure(bool $secure): bool;

  public function getSecure(): bool;
}
