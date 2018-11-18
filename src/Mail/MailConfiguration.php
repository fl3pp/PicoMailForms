<?php

namespace PicoMailPlugin\Mail;

class MailConfiguration {
    private $config;

    public function __construct($config) {
        $this->config = $config['PicoMail'];
    }
    
    public function getFromName() : string {
        return $this->config['SenderName'];
    }
    
    public function getHost() : string {
        return $this->config['Host'];
    }

    public function getSMTPAuth() : bool {
        return true;
    }

    public function getUserName() : string {
        return $this->config['UserName'];
    }
    
    public function getPassword() : string {
        return $this->config['Password'];
    }

    public function getSMPTSecure() : string {
        return 'tls';
    }

    public function getPort() : int {
        return 587;
    }

    public function isHtml() : bool {
        return true;
    }
}