<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\PostConsts;

class ContentCreator {
    private $post;

    public function __construct($post) {
        $this->post = $post;
    }
        
    public function getSubject() {
        return $this->getPostVariableOrDefault(PostConsts::KeySubject, "Without subject");
    }

    public function getSuccessMessage() {
        return $this->getPostVariableOrDefault(PostConsts::KeySuccess, "Your form has successfully been send.");
    }

    public function getFailedMessage() {
        return $this->getPostVariableOrDefault(PostConsts::KeyFailed, "An error occured while sending your message. Please contact the site administrator.");
    }
    
    public function getDataTable() {
        $body = '<table>';
        foreach ($this->getPostUserData() as $key => $value){
            $body .= '<tr>';
            $body .= "<td><b>$key</b></td>";
            $body .= "<td>$value</td>";
            $body .= '</tr>';
        }
        $body .= '</table>';
        return $body;
    }

    public function addUserReceiver($mail) {
        if (!$this->post->isVariableDefined(PostConsts::KeyMail)) {
            return;
        }

        $userMail = $this->post->getVariable(PostConsts::PrefixUserdata.$this->post->getVariable(PostConsts::KeyMail));
        
        $userFirstName = $this->post->isVariableDefined(PostConsts::KeyFirstName) ?
        $this->post->getVariable(PostConsts::PrefixUserdata.$this->post->getVariable(PostConsts::KeyFirstName)) : '';
        $userLastName = $this->post->isVariableDefined(PostConsts::KeyLastName) ?
        $this->post->getVariable(PostConsts::PrefixUserdata.$this->post->getVariable(PostConsts::KeyLastName)) : '';
        
        if ($userFirstName == '' && $userLastName == '') {
            $userName = $userMail ;
        } else if ($userFirstName == '') {
            $userName = $userLastName;
        } else if ($userLastName == '') {
            $userName = $userFirstName;
        } else {
            $userName = $userFirstName . ' ' . $userLastName;
        }

        $mail->To[$userName] = $userMail;
    }

    private function getPostVariableOrDefault($variableName, $default) {
        return $this->post->isVariableDefined($variableName) ?
            $this->post->getVariable($variableName) : $default;
    }

    private function getPostUserData() {
        $data = array();
        foreach ($this->post->getVariables() as $key => $value) {
            if (substr($key, 0, strlen(PostConsts::PrefixUserdata)) != PostConsts::PrefixUserdata) continue;
            $data[substr($key, strlen(PostConsts::PrefixUserdata))] = $value;
        }
        return $data;
    }
}