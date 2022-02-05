<?php namespace SIKessEm\UI\Request;

interface Path_Interface {

  public function setName(string $name): string;

  public function getName(): string;

  public function explode(int $limit = PHP_INT_MAX, ?callable $call = null): mixed;

  public function trim(): static;

  public function matches(string $pattern, ?callable $call = null): mixed;

  public function equals(string $path, ?callable $call = null): mixed;
}