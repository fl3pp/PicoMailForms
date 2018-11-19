<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\PostConsts;

class ContentCreator {
    private $post;

    public function __construct($post) {
        $this->post = $post;
    }
    
    public function setContent($mail) {
        $this->addSubject($mail);
        $this->addBody($mail);
        $this->addReceiver($mail);
    }
    
    public function addSubject($mail) {
        $mail->Subject = $this->post->isVariableDefined(PostConsts::KeySubject) ?
            $this->post->getVariable(PostConsts::KeySubject) : "Without subject";
    }

    public function addBody($mail) {
        $mail->Body = '<html><body><table>';
        foreach ($this->getPostUserData() as $key => $value){
            $mail->Body .= '<tr>';
            $mail->Body .= "<td><b>$key</b></td>";
            $mail->Body .= "<td>$value</td>";
            $mail->Body .= '</tr>';
        }
        $mail->Body .= '</table></body></html>';
    }

    public function addReceiver($mail) {
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

    private function getPostUserData() {
        $data = array();
        foreach ($this->post->getVariables() as $key => $value) {
            if (substr($key, 0, strlen(PostConsts::PrefixUserdata)) != PostConsts::PrefixUserdata) continue;
            $data[substr($key, strlen(PostConsts::PrefixUserdata))] = $value;
        }
        return $data;
    }
}