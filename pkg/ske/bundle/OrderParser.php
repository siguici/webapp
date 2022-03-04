<?php namespace Ske\Bundle;

interface OrderParser {
	public function getName(): string|false;
	public function getData(): array;
}
