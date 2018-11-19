<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\PostConsts;

class ContentCreator {
    private $post;

    public function __construct($post) {
        $this->post = $post;
    }
    
    public function setContent($mail) {
        $mail->Subject = $this->getSubject();
        $mail->Body = $this->getBody();
        $this->addReceiver($mail->Receivers);
    }
    
    public function getSubject() : string {
        return $this->post->getVariable(PostConsts::KeySubject);
    }

    public function getBody() : string {
        $body = '<html><body><table>';
        foreach ($this->getPostUserData() as $key => $value){
            $body .= '<tr>';
            $body .= "<td><b>$key</b></td>";
            $body .= "<td>$value</td>";
            $body .= '</tr>';
        }
        $body .= '</table></body></html>';
        return $body;
    }

    public function addReceiver($receivers) {
        if (!$this->post->isVariableDefined(PostConsts::KeyMail)) {
            return;
        }

        $mail = $this->post->getVariable(PostConsts::KeyMail);

        $firstName = $this->post->isVariableDefined(PostConsts::KeyFirstName) ?
            $this->post->getVariable(PostConsts::KeyFirstName) : '';
        $lastName = $this->post->isVariableDefined(PostConsts::KeyLastName) ?
            $this->post->getVariable(PostConsts::KeyLastName) : '';
        
        if ($firstName == '' && $lastName == '') {
            $name = $mail;
        } else if ($firstName == '') {
            $name = $lastName;
        } else if ($lastName == '') {
            $name = $firstName;
        } else {
            $name = $firstName . ' ' . $lastName;
        }

        $receivers[$name] = $value;
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