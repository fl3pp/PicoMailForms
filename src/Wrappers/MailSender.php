<?php

namespace PicoMailPlugin\Wrappers;

use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception as SMPTException;

class MailSender {

    public function sendMail($mailInfo, &$resultMessage) : bool {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = $mailInfo->SmtpAuth;                           
        $mail->SMTPSecure = $mailInfo->SmtpSecure;                            
        $mail->Port = $mailInfo->Port;                           
        $mail->Host = $mailInfo->Host;
        $mail->Username = $mailInfo->Username;                 
        $mail->Password = $mailInfo->Password;
        $mail->setFrom($mailInfo->Username, $mailInfo->From);
        $mail->isHtml($mailInfo->IsHtml);

        foreach ($mailInfo->To as $name => $address) {
            $mail->addAddress($address, $name);
        }

        $mail->Subject = $mailInfo->Subject;
        $mail->Body = '<html><body>'.$mailInfo->Body.'</body></html>';
        $mail->CharSet = 'UTF-8';

        try {
            $mail->send();
            $resultMessage = "Success";
            return true;
        } catch(SMPTException $ex) {
            $resultMessage = "Failed: " . $phpmail->ErrorInfo;
            return false;
        }
    }
    
}