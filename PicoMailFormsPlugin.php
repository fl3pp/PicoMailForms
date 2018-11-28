<?php

class PicoMailFormsPlugin extends AbstractPicoPlugin {
    const API_VERSION = 2;
    private $plugin;

    public function __construct($pico) {
        $postWrapper = new \PicoMailPlugin\Wrappers\PostWrapper();
        $mailSender = new \PicoMailPlugin\Wrappers\MailSender();
        $this->plugin = new \PicoMailPlugin\Plugin($postWrapper, $mailSender);
        parent::__construct($pico);
    }

    public function onConfigLoaded(&$config) {
        $this->plugin->setConfig($config);
    }

    public function onContentPrepared(&$content) {
        $this->plugin->prepareContent($content);
    }
}
