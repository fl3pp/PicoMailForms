<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\Mail\Receiver;

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
        return $this->post->getVariable('meta_subject');
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
        foreach ($this->getPostUserData() as $key => $value) {
            if ($key == 'userdata_name') {
                $name = $value;
            }
            if ($key == 'userdata_mail') {
                $mail = $value;
            }
        }
        $receivers[$name] = $value;
    }

    private function getPostUserData() {
        $data = array();
        foreach ($this->post-getVariables() as $key => $value) {
            if (substr($key, 0, 9) != 'userdata_') continue;
            $data[substr($key, 9)] = $value;
        }
        return $data;
    }
}