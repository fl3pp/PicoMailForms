<?php

namespace PicoMailPlugin\Test\Integration\Setup;

use PicoMailPlugin\Test\Integration\Setup\TestMailSender;
use PicoMailPlugin\Test\Integration\Setup\TestPost;

class IntegrationTestSetup {
    private $post;
    private $mailSender;

    public function __construct() {
        $this->post = new TestPost();
        $this->mailSender = new TestMailSender();
    }

    public function createTestee() {
        return new \PicoMailPlugin\Plugin($this->post, $this->mailSender);
    }

}