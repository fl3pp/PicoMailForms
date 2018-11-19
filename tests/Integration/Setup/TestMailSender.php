<?php

namespace PicoMailPlugin\Test\Integration\Setup;

class TestMailSender {
    public $Mails = array();
    public $Succeeds = true;

    public function sendMail($mail, &$resultMessage) : bool {
        array_push($this->Mails, $mail);
        return $this->Succeeds;
    }
}

