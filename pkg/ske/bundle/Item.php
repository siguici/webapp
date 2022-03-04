<?php namespace Ske\Bundle;

class Item {
	public function __construct(string $path, array $args = []) {
		$this->setPath($path);
		$this->setArgs($args);
	}

	protected string $path;

	public function setPath(string $path) {
		$this->path = $path;
	}

	public function getPath(): string {
		return $this->path;
	}

	protected array $args;

	public function setArgs(array $args): self {
		$this->args = $args;
		return $this;
	}

	public function getArgs(): array {
		return $this->args;
	}
}
