<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\Mail\MailConfigurator;
use PicoMailPlugin\Mail\Mail;
use PicoMailPlugin\Mail\PageResponseCreator;

class MailAction {
    private $config;
    private $mailSender;
    private $post;

    public function __construct($config, $mailSender, $post) {
        $this->config = $config;
        $this->mailSender = $mailSender;
        $this->post = $post;
    }

    public function run(&$content) {
        $configurator = new MailConfigurator($this->config);
        $contentCreator = new ContentCreator($this->post);

        
        $subject = $contentCreator->getSubject();
        $dataTable = $contentCreator->getDataTable();
        $userSuccessMessage = $contentCreator->getResultMessage(true);
        $userFailedMessage = $contentCreator->getResultMessage(false);
        
        # UserMail
        $userMail = new Mail();
        $configurator->setConfiguration($userMail);
        $userMail->Subject = $subject;
        $userMail->Body .= $userSuccessMessage;
        $userMail->Body .= $dataTable;
        $contentCreator->addReceiver($userMail);

        $sendSuccessfull = $this->mailSender->sendMail($userMail, $resultMessage);
        
        # Page Content
        $content = '';
        $content .= "# $subject\r\n\r\n";
        $content .= $sendSuccessfull ? $userSuccessMessage : $userFailedMessage . "\r\n\r\n";
        $content .= $dataTable;

        # OperatorMail
        $operatorMail = new Mail();
        $configurator->setConfiguration($operatorMail);
        $operatorMail->Subject = "The form '$subject' has been filled";
        $operatorMail->Body .= "<p>";
        $operatorMail->Body .= $sendSuccessfull 
            ? "A user has successfully filled your form: " 
            : "A error occured while a user tried to fill your form: ";
        $operatorMail->Body .= $subject;
        $operatorMail->Body .= "</p>";
        if (!$sendSuccessfull) $operatorMail->Body .= "<p>ERROR: $resultMessage</p>";
        $operatorMail->Body .= $dataTable;
        $configurator->addOperatorReceiver($operatorMail);
        $this->mailSender->sendMail($operatorMail, $message);
    }
}
