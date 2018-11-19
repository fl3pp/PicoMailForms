<?php

namespace PicoMailPlugin\Mail;

class Mail {
    public $IsSmtp;
    public $SmtpSecure;
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
