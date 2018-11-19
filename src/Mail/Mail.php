<?php

namespace PicoMailPlugin\Mail;

class Mail {
    public $IsSmtp;
    public $SmptSecure;
    public $SmtpAuth;
    public $Port;

    public $From;
    public $To = array();
    public $Host;
    public $Username;
    public $Password;

    public $Subject;
    public $IsHtml;
    public $Body;
}
