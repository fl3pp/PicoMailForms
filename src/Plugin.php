<?php

namespace PicoMailPlugin;

use PicoMailPlugin\PostConsts;

class Plugin {
    private $post;
    private $mailSender;
    private $config;

    public function __construct($post, $mailSender) {
        $this->post = $post;
        $this->mailSender = $mailSender;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function prepareContent(&$content) {
        if ($this->post->isVariableDefined(PostConsts::KeyIsPicoMailSend) 
         && $this->post->getVariable(PostConsts::KeyIsPicoMailSend) == PostConsts::TrueValue) {
            $action = new \PicoMailPlugin\Mail\MailAction($this->config, $this->mailSender, $this->post);
        } else {
            $action = new \PicoMailPlugin\Forms\FormAction($this->config);
        }

        $action->run($content);
    }
}