<?php namespace Ske\Util;

interface OrderParser {
	public function parse(): void;
	public function parsed(): bool;
	public function execute(): Result;
}
