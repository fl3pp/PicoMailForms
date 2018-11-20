<?php

namespace PicoMailPlugin\Mail\Builders;

use PicoMailPlugin\Mail\Mail;

class OperatorMailBuilder {
    private $contentCreator;
    private $configurator;

    public function __construct($contentCreator, $configurator) {
        $this->contentCreator = $contentCreator;
        $this->configurator = $configurator;
    }

    public function buildMail($userMailSuccessFull, $sendMessage) {
        $mail = new Mail();
        $this->configurator->setConfiguration($mail);
        $this->configurator->addOperatorReceiver($mail);
        $mail->Subject = 'The form\''.$this->contentCreator->getSubject().'has been filled';        
        $message = $userMailSuccessFull 
        ? "A user has successfully filled your form: " 
        : "A error occured while a user tried to fill your form: ";
        $mail->addParagraph($message.$this->contentCreator->getSubject());
        if (!$userMailSuccessFull) $mail->addParagraph("ERROR: $sendMessage");
        $mail->addHtml($this->contentCreator->getDataTable());
        return $mail;
    }

}