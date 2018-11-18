<?php

class PicoMailFormsPlugin extends AbstractPicoPlugin {
    private $config;

    public function onConfigLoaded(&$config) {
        $this->config = $config;
    }

    public function onContentPrepared(&$content) {
        $action = $this->getAction();
        $action->run($content);
    }

    private function getAction() {
        if (array_key_exists('IsPicoMailSend', $_POST) && $_POST['IsPicoMailSend'] == 'true') {
            return new PicoMailPlugin\MailAction($this->config);
        } else {
            return new PicoMailPlugin\FormAction($this->config);
        }
    }
       
}
