<?php namespace Organizer;

trait Commands {
    protected array $commands = [];

    public function setCommands(array $commands): void {
        foreach ($commands as $command)
            $this->addCommand($command);
    }

    public function addCommand(Command $command): void {
            if ($this->hasCommand($command->getName()))
                    throw new RuntimeException('Command ' . $command->getName() . ' already exists');
            $this->commands[] = $command;
    }

    public function getCommands(): array {
            return $this->commands;
    }

    public function getCommand(string $name): ?Command {
            foreach ($this->commands as $command)
                    if ($command->getName() === $name)
                            return $command;
            return null;
    }

    public function hasCommands(): bool {
            return !empty($this->commands);
    }

    public function hasCommand(string $name): bool {
            foreach ($this->commands as $command)
                    if ($command->getName() === $name)
                            return true;
            return false;
    }
}
