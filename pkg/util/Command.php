<?php namespace Ske\Util;

class Command {
    public function __construct(string $name, string $description = '', string $usage = '') {
        $this->setName($name);
        $this->setDescription($description);
        $this->setUsage($usage);
    }

    protected string $name;

    public function setName(string $name): self {
        if (empty($name)) {
            throw new \Exception('Command name cannot be empty');
        }
        if (!is_file($name)) {
            throw new \Exception("No such file $name");
        }
        $this->name = $name;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    protected string $description;

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    protected string $usage;

    public function setUsage(string $usage): self {
        $this->usage = $usage;
        return $this;
    }

    public function getUsage(): string {
        return $this->usage;
    }

    public function home(): string {
        return "{$this->getName()} {$this->getDescription()}" . PHP_EOL . $this->help();
    }

    public function help(): string {
        return "Usage: {$this->getUsage()}";
    }

    public function parse(int $argc, array $argv): bool {
        return true;
    }
}