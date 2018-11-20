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
        $contentCreator = new ContentCreator($this->post);
        $mailConfigurator = new MailConfigurator($this->config);
        
        $userMailBuilder = new \PicoMailPlugin\Mail\Builders\UserMailBuilder($contentCreator, $mailConfigurator);
        $userMail = $userMailBuilder->buildMail();
        $userSendSuccessfull = $this->mailSender->sendMail($userMail, $sendMessage);
        
        $pageContentBuilder = new \PicoMailPlugin\Mail\Builders\PageContentBuilder($contentCreator);
        $pageContentBuilder->buildContent($content, $userSendSuccessfull);

        $operatorMailBuilder = new \PicoMailPlugin\Mail\Builders\OperatorMailBuilder($contentCreator, $mailConfigurator);
        $operatorMail = $operatorMailBuilder->buildMail($userSendSuccessfull, $sendMessage);
        $this->mailSender->sendMail($operatorMail, $operatorSendMessage);
    }
}
