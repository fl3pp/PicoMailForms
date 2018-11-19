<?php

namespace PicoMailPlugin\Mail;

class MailConfigurator {
    private $config;

    public function __construct($config) {
        $this->config = $config['PicoMail'];
    }

    public function setConfiguration($mail) {
        $this->addDefaultReceiver($mail);
        $this->setFromName($mail);
        $this->setHost($mail);
        $this->setSmptAuth($mail);
        $this->setUserName($mail);
        $this->setPassword($mail);
        $this->setSmptSecure($mail);
        $this->setPort($mail);
        $this->setIsHtml($mail);
    }

    private function addDefaultReceiver() {
        if (!array_key_exists('DefaultReceiverName', $this->config)
         || !array_key_exists('DefaultReceiverMail', $this->config)) {
            return;
        }
        
        $defaultName = $this->config['DefaultReceiverName'];
        $defaultMail = $this->config['DefaultReceiverName'];
        $mail->To[$defaultName] = $defaultMail;
    }
    
    private function setFromName($mail) {
        $mail->From = $this->config['SenderName'];
    }
    
    private function setHost($mail) {
        $mail->Host = $this->config['Host'];
    }

    private function setSmptAuth($mail) {
        $mail->SmtpAuth = true;
    }

    private function setUserName($mail) {
        $mail->Username = $this->config['UserName'];
    }
    
    private function setPassword($mail) {
        $mail->Password = $this->config['Password'];
    }

    private function setSmptSecure($mail) {
        $mail->SmtpSecure = 'tls';
    }

    private function setPort($mail) {
        $mail->Port = 587;
    }

    private function setIsHtml($mail) {
        $mail->IsHtml = true;
    }
}