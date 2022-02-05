<?php namespace SIKessEm\UI\Request;

trait Path_Trait {

  protected string $name;

  public function setName(string $name): string {

    return $this->name = preg_replace('/(\/|\\\)+/', '/', $name);
  }

  public function getName(): string {

    return $this->name;
  }

  public function explode(int $limit = PHP_INT_MAX, ?callable $call = null): mixed {

    $parts = explode('/', $this->name, $limit);
    return isset($call) ? $call($parts, $this) : $parts;
  }

  public function trim(): static {

    $this->name = trim($this->name, '/');
    return $this;
  }

  public function matches(string $pattern, ?callable $call = null): mixed {

    return preg_match($pattern, $this->name, $matches) ? (isset($call) ? $call($matches, $this) : $matches) : false;
  }

  public function equals(string $path, ?callable $call = null): mixed {

    return $this->name === $path ? (isset($call) ? $call($this) : true) : false;
  }
}