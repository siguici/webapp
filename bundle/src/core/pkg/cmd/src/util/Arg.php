<?php namespace Ske\Cmd;

abstract class Arg {
    public function __construct(string $name, string|array|null $aliases = null) {
        $this->setName($name);
        $this->setAliases($aliases);
    }

    protected string $name;

    public function setName(string $name): void {
        if (empty($name))
            throw new \InvalidArgumentException('Empty argument name given');
        if (!preg_match('/^[+-]*[^\s:=+-]{2,}$/s', $name))
            throw new \InvalidArgumentException("Invalid argument name ($name) given");
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    protected array $aliases = [];

    public function setAliases(null|string|array $aliases = null): void {
        $this->aliases = [];
        $aliases = (array) $aliases;
        foreach ($aliases as $alias)
            $this->setAlias($alias);
    }

    public function setAlias(string $alias): void {
        if (!in_array($alias, $this->aliases, true)) {
            if (isset($alias) && !preg_match('/^[+-]?[^\s:=+-]$/s', $alias))
                throw new \InvalidArgumentException("Invalid alias ($alias) given");
            $this->aliases[] = $alias;
        }
    }

    public function getAliases(): ?string {
        return $this->aliases;
    }

    public function hasAliases(): bool {
        return !empty($this->aliases);
    }

    public function hasAlias(string $alias): bool {
        return in_array($alias, $this->aliases, true);
    }

    public function match(string $arg): bool {
        if (fnmatch($this->getName(), $arg))
            return true;
        foreach ($this->getAliases() as $alias)
            if (fnmatch($alias, $arg))
                return true;
        return false;
    }
}
