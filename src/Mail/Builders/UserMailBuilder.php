<?php

namespace PicoMailPlugin\Mail\Builders;

use PicoMailPlugin\Mail\Mail;

class UserMailBuilder {
    private $contentCreator;
    private $configurator;

    public function __construct($contentCreator, $configurator) {
        $this->contentCreator = $contentCreator;
        $this->configurator = $configurator;
    }

    public function buildMail() {
        $mail = new Mail();
        $this->configurator->setConfiguration($mail);
        $this->contentCreator->addUserReceiver($mail);
        $mail->Subject = $this->contentCreator->getSubject();
        $mail->Body .= '<p>'.$this->contentCreator->getSuccessMessage().'</p>';
        $mail->Body .= $this->contentCreator->getDataTable();
        return $mail;
    }
    
}