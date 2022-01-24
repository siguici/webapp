<?php namespace SIKessEm\UI\Request;

interface Query_Interface {
  
  public function setString(string $string): static;

  public function getString(): string;

  public function getData(): array;

  public function setData(array $data): array;

  public function getValue(string|int $key): mixed;

  public function setValue(string|int $key, mixed $value): static;
}