<?php

namespace Vendor\App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    private function buildMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        $mail->SMTPDebug  = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(
            $_ENV['MAIL_FROM_ADDRESS'],
            $_ENV['MAIL_FROM_NAME']
        );

        return $mail;
    }

    public function sendOtpEmail(
        string $toEmail,
        string $toName,
        string $otp
    ): bool {
        try {
            $mail = $this->buildMailer();

            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = 'Your Email Verification OTP';
            $mail->Body    = "
                <div style='font-family:sans-serif;max-width:400px;margin:auto;padding:24px;border:1px solid #eee;border-radius:8px;'>
                    <h2 style='color:#1a1a1a;'>Hello, {$toName}!</h2>
                    <p style='color:#555;'>Your OTP to verify your email is:</p>
                    <h1 style='letter-spacing:10px;color:#f97316;font-size:36px;'>{$otp}</h1>
                    <p style='color:#555;'>This OTP is valid for <b>5 minutes</b>.</p>
                    <p style='color:#999;font-size:12px;'>Do not share this OTP with anyone.</p>
                </div>
            ";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    public function sendForgotOtpEmail(
        string $toEmail,
        string $toName,
        string $otp
    ): bool {
        try {
            $mail = $this->buildMailer();

            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = 'Your Password Reset OTP';
            $mail->Body    = "
                <div style='font-family:sans-serif;max-width:400px;margin:auto;padding:24px;border:1px solid #eee;border-radius:8px;'>
                    <h2 style='color:#1a1a1a;'>Hello, {$toName}!</h2>
                    <p style='color:#555;'>Your OTP to reset your password is:</p>
                    <h1 style='letter-spacing:10px;color:#f97316;font-size:36px;'>{$otp}</h1>
                    <p style='color:#555;'>This OTP is valid for <b>5 minutes</b>.</p>
                    <p style='color:#999;font-size:12px;'>If you did not request this, ignore this email.</p>
                </div>
            ";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}