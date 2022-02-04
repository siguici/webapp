<?php namespace Organizer;

class CLI {

    public function execute(int $argc, array $argv): void {
        $cli_dir = $this->root . ($this->options['program']['cli-dir'] ?? self::CLI_DIR);
        $cli_cfg = $this->root . ($this->options['program']['cli-cfg'] ?? self::CLI_CFG);
		$app_name = array_shift($argv);
		--$argc;
        $app = new Application($cli_dir, $app_name, require $cli_cfg);
        $app->execute($argc, $argv);
    }
    
    protected static self $ORGANIZER;

    /**
     * Initialize Organizer
     */
    public static function initialize(?string $root, array $options = []): self {
        return self::$ORGANIZER = new self($root, $options);
    }

    /**
     * Get the current organizer
     *
     * @throws \RuntimeException If Organizer is not initialized
     * @return self The current organizer
     */
    public static function organizer(): Organizer {
        if (!isset(self::$ORGANIZER))
            throw new \RuntimeException('Initialize Organizer using Organizer::initialize()');
        return self::$ORGANIZER;
    }

    protected static ?Module $module;

    /**
     * Import modules
     */
    public static function module(string $name, bool $once = false): Module {
        $name = self::organizer()->getRoot() . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
        self::$module = new Module($name);
        self::import($name, $once);
        return self::$module;
    }

    /**
     * Import modules
     */
    public static function import(string $name, bool $once = false): mixed {
        $name = self::organizer()->getRoot() . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';
        return (new Imports($name, $once))->make();
    }
    
    /**
     * Export values
     */
    public static function export(mixed $value, mixed ...$values): Values {
        if (!isset(self::$module))
            throw new \RuntimeException('Import this module using Organizer::import()');
        return self::$module->export($value, ...$values);
    }
}
