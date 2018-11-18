<?php

namespace PicoMailPlugin;

use PicoMailPlugin\PostKeys;

class Plugin {
    private $post;
    private $config;

    public function __construct(
        $post
    ) {
        $this->post = $post;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function prepareContent(&$content) {
        if ($this->post->isVariableDefined(PostKeys::IsPicoMailSend) 
         && $this->post->getVariable(PostKeys::IsPicoMailSend) == PostKey::TrueValue) {
            $action = new PicoMailPlugin\Mail\MailAction($this->config);
        } else {
            $action = new PicoMailPlugin\Forms\FormAction($this->config);
        }

        $action->run($content);
    }
    

}