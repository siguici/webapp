<?php namespace SIKessEm\UI\Request;

interface Method_Interface {

  public function setVerb(string $verb): string;

  public function getVerb(): string;

  public function is(string $verb, ?callable $call = null): bool;

  public function isNot(string $verb, ?callable $call = null): bool;

  public function in(array $verbs, ?callable $call = null): bool;

  public function notIn(array $verbs, ?callable $call = null): bool;
}
