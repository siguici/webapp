<?php namespace Ske\Cli;

use \RuntimeException;

class Command extends Arg {
    public function __construct(string $name, array $args = [], null|string|array $aliases = null) {
        parent::__construct($name, $aliases);
        $this->addArgs($args);
    }

    protected array $args = [];

    public function addArgs(array $args): void {
        foreach($args as $arg)
            $this->addArg($arg);
    }

    public function addArg(Arg $arg): void {
        if ($this->hasArg($arg->getName()))
            throw new RuntimeException('Argument ' . $arg->getName() . ' already exists');
        $this->args[] = $arg;
    }

    public function setArgs(array $args): void {
        foreach($args as $name => $arg)
            $this->setArg($name, $arg);
    }

    public function setArg(string $name, Arg $arg): void {
        if ($_arg = $this->getArg($name)) {
            $key = array_search($_arg, $this->args, true);
            $this->args[$key] = $arg;
        }
    }

    public function getArgs(): array {
        return $this->args;
    }

    public function getArg(string $name): ?Arg {
        foreach ($this->args as $arg)
            if ($arg->getName() === $name)
                return $arg;
        return null;
    }

    public function hasArgs(): bool {
        return !empty($this->args);
    }

    public function hasArg(string $name): bool {
        foreach ($this->args as $arg)
            if ($arg->getName() === $name)
                return true;
        return false;
    }
}
