<?php namespace SIKessEm\UI\Request;

trait Method_Trait {

  public function setVerb(string $verb): string {

    return $this->verb = strtoupper(trim($verb));
  }

  public function getVerb(): string {

    return $this->verb;
  }

  public function is(string $verb, ?callable $call = null): bool {

    return strtoupper(trim($verb)) === $this->verb ? (isset($call)? $call($this->verb): true) : false;
  }

  public function isNot(string $verb, ?callable $call = null): bool {

    return strtoupper(trim($verb)) !== $this->verb ? (isset($call)? $call($this->verb): true) : false;
  }

  public function in(array $verbs, ?callable $call = null): bool {

    foreach($verbs as $verb) 
      if($checked = $this->is($verb, $call)) return $checked;
    
    return false;
  }

  public function notIn(array $verbs, ?callable $call = null): bool {

    foreach($verbs as $verb) 
      if($this->is($verb)) return false;
    
    return isset($call) ? $call($this->verb) : true;
  }
}