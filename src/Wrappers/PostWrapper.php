<?php

namespace PicoMailPlugin\Wrappers;

/**
 * @codeCoverageIgnore
 */
class PostWrapper {

    public function getVariable(string $key) : string {
        return $_POST[$key];
    }

    public function isVariableDefined(string $key) : bool {
        return array_key_exists($key, $_POST);
    }

    public function getVariables() : array {
        $postVariables = array();
        foreach ($_POST as $key => $value) {
            $postVariables[$key] = strip_tags($value);
        }
        return $postVariables;       
    }
    
}