<?php namespace Ske\IO;

interface API_Interface {
    public function setInput(Input_Interface $input): Input_Interface;
    public function getInput(): Input_Interface;
    public function setOutput(Output_Interface $output): Output_Interface;
    public function getOutput(): Output_Interface;
}
