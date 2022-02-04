<?php namespace Ske\Cmd;

class ArgsTester {
    protected Args $args;
    
    public function __construct() {
        $this->args = new Args(5, ['php', 'run', 'ske', 'app', 'test']);
    }
    
    public function testValues(): bool {
        return $this->args->values() === ['php', 'run', 'ske', 'app', 'test'];
    }
    
    public function testCount(): bool {
        return $this->args->count() === 5;
    }

    public function testGetArg(): bool {
        foreach (['php', 'run', 'ske', 'app', 'test'] as $index => $value) {
            if ($this->args->getArg($index) !== $value)
                return false;
        }
        return true;
    }
    
    public function testSetArg(): bool {
        $this->args->setArg(2, 'sikessem');
        return $this->args->getArg(2) === 'sikessem';
    }
    
    public function testAddArg(): bool {
        $this->args->addArg('dev');
        return $this->$this->args->getArg(5) === 'dev';
    }
}
