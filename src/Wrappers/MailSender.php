<?php

namespace PicoMailPlugin\Wrappers;

use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception as SMPTException;

class MailSender {

    public function sendMail($mail, &$resultMessage) : bool {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = $mail->SmtpAuth;

        $mail->setFrom($mail->Username, $mail->From);
        $mail->Host = $mail->Host;
        $mail->Username = $mail->Username;
        $mail->Password = $staticConfiguration->Password;
        $mail->SMTPSecure = $staticConfiguration->SmptSecure;
        $mail->Port = $staticConfiguration->Port;
        $mail->isHtml($staticConfiguration->IsHtml);
        
        foreach ($mail->To as $receiver) {
            $mail->addAddress($receiver->Address, $receiver->Name);
        }

        $mail->Subject = $contentCreator->Subject;
        $mail->Body = $contentCreator->Body;

        try {
            $mail->send();
            $resultMessage = "Success";
            return true;
        } catch(SMPTException $ex) {
            $resultMessage = "Failed: " . $mail->ErrorInfo;
            return false;
        }
    }
    
}