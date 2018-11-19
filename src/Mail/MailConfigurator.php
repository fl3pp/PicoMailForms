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
        $this->setSmtpAuth($mail);
        $this->setUserName($mail);
        $this->setPassword($mail);
        $this->setSmtpSecure($mail);
        $this->setPort($mail);
        $this->setIsHtml($mail);
        $this->setIsSmtp($mail);
    }

    private function addDefaultReceiver() {
        if (!array_key_exists('DefaultReceiverName', $this->config)
         || !array_key_exists('DefaultReceiverMail', $this->config)) {
            return;
        }
        
        $defaultName = $this->config['DefaultReceiverName'];
        $defaultMail = $this->config['DefaultReceiverMail'];
        $mail->To[$defaultName] = $defaultMail;
    }
    
    private function setFromName($mail) {
        $mail->From = $this->config['SenderName'];
    }
    
    private function setHost($mail) {
        $mail->Host = $this->config['Host'];
    }

    private function setSmtpAuth($mail) {
        $mail->SmtpAuth = true;
    }

    private function setUserName($mail) {
        $mail->Username = $this->config['UserName'];
    }
    
    private function setPassword($mail) {
        $mail->Password = $this->config['Password'];
    }

    private function setSmtpSecure($mail) {
        $mail->SmtpSecure = 'tls';
    }

    private function setPort($mail) {
        $mail->Port = $this->config['Port'];
    }

    private function setIsHtml($mail) {
        $mail->IsHtml = true;
    }

    private function setIsSmtp($mail) {
        $mail->IsSmtp = true;
    }
}