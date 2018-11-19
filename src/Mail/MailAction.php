<?php

namespace PicoMailPlugin\Mail;

use PicoMailPlugin\Mail\MailConfigurator;
use PicoMailPlugin\Mail\Mail;

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
        $contentCreator->setContent($mail);

        $this->mailSender->sendMail($mail, $message);

        $content = $message;
    }
}
