<?php

namespace PicoMailPlugin\Mail;

use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception as SMPTException;

class MailAction {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function run(&$content) {
        $mail = new PHPMailer(true);
        $staticMailConfiguration = new MailConfiguration($this->config);
        $contentCreator = new ContentCreator();
        $mailConfigurator = new MailConfigurator();
        $mailConfigurator->configureMail($mail, $staticMailConfiguration, $contentCreator);
        $mail->addAddress('jann@flepp.ch', 'Jann Flepp');
        
        try {
            $mail->send();
            $content = file_get_contents('..\Templates\success.md');
        } catch(SMPTException $ex){
            $content = file_get_contents('..\Templates\error.md');
            $content = str_replace('[error]', $mail->ErrorInfo);
        }
    }
    
}