<?php 

namespace Vendor\App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    private function buildMailer()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'] ?? '';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
        $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? '', $_ENV['MAIL_FROM_NAME'] ?? '');
        return $mail;
    }

    public function sendOtpEmail(string $toEmail, string $toName, string $otp)
    {
        try{
            $mail = $this->buildMailer();

            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = "Email verification Otp";
            $mail->Body = "
            <h2>Hello {$toName}!</h2>
            <p?>Your OTP to Verify your Mail is :</p>
            <h1 style='letter-spacing:8px;color:#e8a020'>{$otp}</h1>
            <p>This OTP is valid for 5 minutes.</p>";
            $mail->send();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function sendForgotOtpEmail(string $toEmail, string $toName, string $otp)
    {
        try{
            $mail = $this->buildMailer();

            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = "Email verification Otp";
            $mail->Body = "
            <h2>Hello {$toName}!</h2>
            <p?>Your OTP to reset Password is:</p>
            <h1 style='letter-spacing:8px;color:#e8a020'>{$otp}</h1>
            <p>This OTP is valid for 5 minutes.</p>";
            $mail->send();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}