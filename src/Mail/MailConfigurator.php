<?php

namespace PicoMailPlugin\Mail;

class MailConfigurator {
    
    public function configureMail($mail, $staticConfiguration, $contentCreator) {
        $mail->isSMTP();

        $mail->setFrom($staticConfiguration->getUserName(), $staticConfiguration->getFromName());
        $mail->Host = $staticConfiguration->getHost();
        $mail->SMTPAuth = $staticConfiguration->getSMTPAuth();
        $mail->Username = $staticConfiguration->getUserName();
        $mail->Password = $staticConfiguration->getPassword();
        $mail->SMTPSecure = $staticConfiguration->getSMPTSecure();
        $mail->Port = $staticConfiguration->getPort();
        $mail->isHtml($staticConfiguration->isHtml());
        
        $mail->Subject = $contentCreator->getSubject();
        $mail->Body = $contentCreator->getBody();
    }
}

