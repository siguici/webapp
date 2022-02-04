<?php namespace Ske\Cli;

trait Flags {
    protected array $flags = [];

    public function setFlags(array $flags): void {
        foreach ($flags as $flag)
            $this->addFlag($flag);
    }

    public function addFlag(Flag $flag): void {
        if ($this->hasFlag($flag->getName()))
            throw new RuntimeException('Flag ' . $flag->getName() . ' already exists');
        $this->flags[] = $flag;
    }

    public function getFlags(): array {
        return $this->flags;
    }

    public function getFlag(string $name): ?Flag {
        foreach ($this->flags as $flag)
            if ($flag->getName() === $name)
                return $flag;
        return null;
    }

    public function hasFlags(): bool {
        return !empty($this->flags);
    }

    public function hasFlag(string $name): bool {
        foreach ($this->flags as $flag)
            if ($flag->getName() === $name)
                return true;
        return false;
    }
}
