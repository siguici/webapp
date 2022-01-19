<?php namespace SIKessEm\IO;

trait API_Trait {
    protected Input_Interface $input;

    public function setInput(Input_Interface $input): Input_Interface {
        return $this->input = $input;
    }

    public function getInput(): Input_Interface {
        return $this->input;
    }

    protected Output_Interface $output;

    public function setOutput(Output_Interface $output): Output_Interface {
        return $this->output = $output;
    }

    public function getOutput(): Output_Interface {
        return $this->output;
    }
}
