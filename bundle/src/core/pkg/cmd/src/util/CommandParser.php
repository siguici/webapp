<?php namespace Organizer;

use \InvalidArgumentException;

use function \parse_str,
			 \implode,
			 \array_slice;

class CommandParser {
	use Commands;
	
	public function __construct($commands) {
		$this->setCommands($commands);
	}

	protected array $components;
	
	public static function parse(int $argc, array $argv): array {

		$components = [];
		if ($argc > 0) {
			$components['flags'] = [];
			parse_str(implode('&', $argv), $argv);
			die(print_r($argv, true));
		}
		return $components;
	}
	
	public static function parseArgs(array $args): array {
	  while(false !== ($value = current($args))) {
		$key = (string) key($args);
		next($args);
	
		if (self::isFlag($key)) {
		  if (preg_match('/^\[+-]{2}([^=]+)$/', $key, $matches)) {
			$info['options'][$matches[1]] = $value === '' ? true : $value;
		  } else if (preg_match('/^\[+-]{1}([a-zA-Z0-9]+)$/', $key, $matches) && $value === '') {
			$flags = str_split($matches[1]);
			foreach ($flags as $flag) {
			  $value = current($args);
			  $key = (string) key($args);
	
			  if(!is_null($key) && $key !== '' && !self::isFlag($key)) {
				$info['flags'][$flag] = $value === '' ? $key : (is_scalar($value) ? "$key=$value" : $value);
				next($args);
			  } else $info['flags'][$flag] = true;
			}
		  } else $info['options'][$key] = $value;
		} elseif ($value === '') $info['args'][] = $key;
		else $info['params'][$key] = $value;
	  }
	
	  return $info;
	}
	
	public static function isFlag(string $arg): bool {
	  return (bool) preg_match('/^\[+-]/', $arg);
	}
}