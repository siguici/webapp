<?php namespace Ske\IO;

class Input extends Abstract_Input {
    use Input_Trait;

    public function read(int $length): string|false {
        return fread($this->getStream(), $length);
    }
}
