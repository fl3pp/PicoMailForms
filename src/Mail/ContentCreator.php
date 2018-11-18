<?php

namespace PicoMailPlugin\Mail;

class ContentCreator {
    
    public function getSubject() : string {
        return $this->getPostVariableOrDefault('meta_subject');
    }

    public function getBody() : string {
        $variables = $this->getPostVariables();
        $body = '<html><body><table>';
        foreach ($variables as $key => $value){
            $body .= '<tr>';
            $body .= "<td><b>$key</b></td>";
            $body .= "<td>$value</td>";
            $body .= '</tr>';
        }
        $body .= '</table></body></html>';
        return $body;
    }

    private function getPostVariableOrDefault(string $variableName) : string {
        if (array_key_exists($variableName, $_POST))
            return strip_tags($_POST[$variableName]);
        else
            return null;
    }

    private function getPostVariables() {
        $postVariables = array();
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 9) != 'userdata_') continue;
            $postVariables[substr($key, 9)] = strip_tags($value);
        }
        return $postVariables;
    }
}