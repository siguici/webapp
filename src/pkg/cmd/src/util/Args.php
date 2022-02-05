<?php namespace Ske\Cmd;

class Args {
    public function __construct(protected int $count, protected array $values) {
        if ($count < 1 || $count !== count($values))
            throw new Exception('Wrong count of arguments', Exception::WRONG_COUNT);

        foreach ($values as $index => $value)
            if (!is_string($value))
                throw new Exception("Argument $index must be a string", Exception::INVALID_VALUE);
    }
    
    public function count(): int {
        return $this->count;
    }
    
    public function values(): array {
        return $this->values;
    }
    
    public function setArg(int $index, string $value): void {
        if ($index < 0 || $index >= $this->count)
            throw new Exception("The index ($index) must be greater than or equal to 0 and strictly less than {$this->count}", Exception::OVERFLOW_INDEX);
        $this->values[$index] = $value;
    }
    
    public function getArg(int $index): ?string {
        return $this->values[$index] ?? null;
    }
    
    public function addArg(string $value): void {
        $this->values[] = $value;
        $this->count++;
    }
}
