<?php

namespace PicoMailPlugin\Test\Integration\Setup;

class TestPost {
    public $Data = array();

    public function getVariable(string $key) { 
        return $this->Data[$key]; 
    }

    public function isVariableDefined(string $key) { 
        return array_key_exists($key, $this->Data); 
    }

    public function getVariables() { 
        return $this->Data;       
    }
}