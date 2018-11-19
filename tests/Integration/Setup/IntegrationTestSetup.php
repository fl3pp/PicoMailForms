<?php

namespace PicoMailPlugin\Test\Integration\Setup;

use PicoMailPlugin\Test\Integration\Setup\TestMailSender;
use PicoMailPlugin\Test\Integration\Setup\TestPost;

class IntegrationTestSetup {
    public $Post;
    public $MailSender;

    public function __construct() {
        $this->Post = new TestPost();
        $this->MailSender = new TestMailSender();
    }

    public function parseConfig($config) {
        $parser = new \Symfony\Component\Yaml\Parser();
        return $parser->parse($config) ?: array();
    }

    public function createTestee() {
        return new \PicoMailPlugin\Plugin($this->Post, $this->MailSender);
    }

}