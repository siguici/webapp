<?php namespace Ske\IO;

class Output extends Abstract_Output {
    use Output_Trait;

    public function write(string $text, ?int $length = null): int|false {
        return fwrite($this->getStream(), $text, $length);
    }
}
