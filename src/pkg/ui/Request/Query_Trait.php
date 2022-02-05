<?php namespace SIKessEm\UI\Request;

trait Query_Trait {
  
  protected array $data = [];

  public function setString(string $string): static {

    parse_str($string, $this->data);
    return $this;
  }

  public function getString(): string {

    return http_build_query($this->data);
  }

  public function getData(): array {

    return $this->data;
  }

  public function setData(array $data): array {

    return $this->data = $data;
  }

  public function getValue(string|int $key): mixed {

    return $this->data[$key] ?? null;
  }

  public function setValue(string|int $key, mixed $value): static {

    $this->data[$key] = $value;
    return $this;
  }
}