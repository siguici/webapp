<?php namespace SIKessEm\UI\Request;

trait Fragment_Trait {

  public function setAnchor(string $anchor): string {

    return $this->anchor = $anchor;
  }

  public function getAnchor(): string {

    return $this->anchor;
  }
}