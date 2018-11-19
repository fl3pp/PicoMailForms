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

        $mail = new Mail();

        $configurator->setConfiguration($mail);
        $mail->Subject = $contentCreator->getSubject();
        $mail->Body .= $contentCreator->getResultMessage(true);
        $mail->Body .= $contentCreator->getDataTable();
        $contentCreator->addReceiver($mail);

        $sendSuccessfull = $this->mailSender->sendMail($mail, $resultMessage);
        
        $content = '';
        $content .= '# ' . $contentCreator->getSubject() . "\r\n\r\n";
        $content .= $contentCreator->getResultMessage($sendSuccessfull) . "\r\n\r\n";
        $content .= $contentCreator->getDataTable();
    }
}
