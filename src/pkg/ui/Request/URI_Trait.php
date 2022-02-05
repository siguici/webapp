<?php namespace SIKessEm\UI\Request;

trait URI_Trait {

  public function setAddress(string $address): static {

    $info = parse_url($address);

    preg_match('/^(.*)(s?)$/', $info['scheme'] ?? '', $matches);
    $this->protocol = new Protocol(strtoupper($matches[1]), !empty($matches[2]));
    
    $this->authority = new Authority(
      $info['host'] ?? null,
      $info['port'] ?? null,
      $info['user'] ?? null,
      $info['password'] ?? null,
    );
  
    $this->path = new Path($info['path'] ?? '');
    $this->query = new Query($info['query'] ?? '');
    $this->fragment = new Fragment($info['fragment'] ?? '');

    return $this;
  }

  protected Protocol_Interface $protocol;

  public function getProtocol(): Protocol_Interface {

    return $this->protocol;
  }

  protected Authority_Interface $authority;

  public function getAuthority(): Authority_Interface {

    return $this->authority;
  }

  protected Path_Interface $path;

  public function getPath(): Path_Interface {

    return $this->path;
  }

  protected Query_Interface $query;

  public function getQuery(): Query_Interface {

    return $this->query;
  }

  protected Fragment_Interface $fragment;

  public function getFragment(): Fragment_Interface {

    return $this->fragment;
  }
}