<?php namespace Organizer;

use \ErrorException, \Throwable;

class Debugger {
	public static function debugError(int $severity, string $message, string $file, int $line): never {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
	
	public static function debugException(Throwable $e): never {
        self::debug($e);
    }
	
	public static function debug(mixed $bug): string {
		$render = '';
		if (in_array(PHP_SAPI, ['cli', 'phpdbg'])) {
			$render .= '================================================================' . PHP_EOL;
			$render .= 'Debug ' . gettype($bug) . PHP_EOL;
			$render .= '================================================================' . PHP_EOL;
			if (!is_object($bug) || !$bug instanceof Throwable)
				$render .= var_dump($bug);
			else {
				while ($bug) {
					$render .= get_class($bug) . ' (' . $bug->getCode() . ')' . PHP_EOL;
					$render .= '----------------------------------------------------------------' . PHP_EOL;
					$render .= $bug->getMessage() . ' in "' . $bug->getFile() . '" on line ' . $bug->getLine() . PHP_EOL;
					$render .= '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++' . PHP_EOL;
					$render .= $bug->getTraceAsString() . PHP_EOL;
					$render .= '================================================================' . PHP_EOL;
					$bug = $bug->getPrevious();
				}
			}
		}
		else {
			$render = '<DOCTYPE html><html lang="en_US"><head><title>Debug' . getType($bug) . '</title></head><body><main>';
			if (!is_object($bug) || !$bug instanceof Throwable)
				$render .= var_dump($bug);
			else {	
				$e = $this->e;
				while ($e) {
					$render .= '<div class="e">';
					$render .= '<h1 class="e-name">' . get_class($e) . '</h1>';
					$render .= '<p class="e-info">Thrown with code <b>' . $e->getCode() . '</b> and message <q>' . $e->getMessage() . '</q> in the file <b class="file">' . $e->getFile() . '</b> on line <b class="line">' . $e->getLine() . '</b></u></p>';
					foreach ($e->getTrace() as $trace) {
						$render .= '<div class="e-trace"><p>Trace in the file <b class="file">' . $trace['file'] . '</b> on line <b class="line">' . $trace['line'] . '</b></p></div>';
					}
					$render .= '</div>';
					$e = $e->getPrevious();
				}
			}
			$render .= '</main></body></html>';
		}
		echo $render;
        exit(1);
	}
}