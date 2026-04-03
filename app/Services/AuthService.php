<?php

namespace Vendor\App\Services;

use Vendor\App\Models\User;
use Vendor\App\Models\EmailVerification;
use Vendor\App\Models\ResetPasswordOtp;
use Vendor\App\Services\MailService;

class AuthService
{
    private $userConn;
    private $emailVerifyConn;
    private $resetOtpConn;
    private MailService $mailService;

    public function __construct()
    {
        $this->userConn = new User()->conn;
        $this->emailVerifyConn = new EmailVerification()->conn;
        $this->resetOtpConn = new ResetPasswordOtp()->conn;
        $this->mailService = new MailService();
    }

    public function register(string $name, string $email, string $phone, string $city, string $password)
    {
        $checkEmail = $this->userConn->prepare("SELECT id, is_verified FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $existingUser = $checkEmail->get_result()->fetch_assoc();

        if ($existingUser) {
            if ((int)$existingUser['is_verified'] === 0) {
                $sent = $this->generateAndSendOtp($existingUser['id'], $email, $name);
                return ['status' => 'resend', 'email' => $email, 'sent' => $sent];
            }

            return ['status' => 'exists', 'email' => $email, 'sent' => false];
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->userConn->prepare("INSERT INTO users (name, email, phone, city, password, is_verified)
                VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssss", $name, $email, $phone, $city, $hashPassword);
        $stmt->execute();
        $userId = $this->userConn->insert_id;

        $sent = $this->generateAndSendOtp($userId, $email, $name);
        return [
            'status' => 'registered',
            'email' => $email,
            'sent' => $sent,
        ];
    }

    public function generateAndSendOtp(int $userId, string $email, string $name)
    {
        $deleteOtp = $this->emailVerifyConn->prepare("DELETE FROM email_verification WHERE user_id = ?");
        $deleteOtp->bind_param("i", $userId);
        $deleteOtp->execute();

        $otp = rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', time() + (5 * 60));
        $stmt = $this->emailVerifyConn->prepare("INSERT INTO email_verification (user_id, otp, expires_at, attempts)
                VALUES (?, ?, ?, 0)");
        $stmt->bind_param("iss", $userId, $otp, $expiresAt);
        $stmt->execute();
        return $this->mailService->sendOtpEmail($email, $name, $otp);
    }

    public function verifyOtp(string $email, string $otp)
    {
        $checkEmail = $this->userConn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $user = $checkEmail->get_result()->fetch_assoc();

        if (!$user) {
            return 'user_not_found';
        }

        $userId = (int)$user['id'];

        $stmt = $this->emailVerifyConn->prepare("SELECT * FROM email_verification WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $verification = $stmt->get_result()->fetch_assoc();

        if (!$verification) {
            return 'otp_not_found';
        }

        if ((int)$verification['attempts'] >= 3) {
            return 'max_attempts';
        }

        if (date('Y-m-d H:i:s') > $verification['expires_at']) {
            return 'expired';
        }

        if ($verification['otp'] != $otp) {
            $otpcount = $this->emailVerifyConn->prepare("UPDATE email_verification SET attempts = attempts + 1 WHERE user_id = ?");
            $otpcount->bind_param("i", $userId);
            $otpcount->execute();

            return 'wrong_otp';
        }

        $verifyOtp = $this->userConn->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
        $verifyOtp->bind_param("i", $userId);
        $verifyOtp->execute();

        return 'success';
    }

    public function resendOtp(string $email)
    {
        $stmt = $this->userConn->prepare("SELECT id, name, is_verified FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return 'user_not_found';
        }

        if ((int)$user['is_verified'] === 1) {
            return 'already_verified';
        }

        $sent = $this->generateAndSendOtp($user['id'], $email, $user['name']);

        return $sent ? 'sent' : 'mail_failed';
    }

    public function login(string $email, string $password)
    {
        $stmt = $this->userConn->prepare("SELECT * FROM users WHERE email = ? AND deleted_at IS NULL");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return 'not_found';
        }

        if (!password_verify($password, $user['password'])) {
            return 'wrong_password';
        }

        if ((int)$user['is_verified'] === 0) {
            return 'unverified';
        }

        return $user;
    }

    public function sendForgotOtp(string $email)
    {
        $stmt = $this->userConn->prepare("SELECT id, name FROM users WHERE email = ? AND deleted_at IS NULL");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return 'not_found';
        }

        $deleteOtp = $this->resetOtpConn->prepare("DELETE FROM reset_password_otp WHERE user_id = ?");
        $deleteOtp->bind_param("i", $user['id']);
        $deleteOtp->execute();

        $otp = rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', time() + (5 * 60));

        $storeOtp = $this->resetOtpConn->prepare("INSERT INTO reset_password_otp (user_id, otp, expires_at, attempts)
        VALUES (?, ?, ?, 0)");
        $storeOtp->bind_param("iss", $user['id'], $otp, $expires_at);
        $storeOtp->execute();

        $sent = $this->mailService->sendForgotOtpEmail($email, $user['name'], $otp);

        return $sent ? 'sent' : 'mail_failed';
    }

    public function verifyFOrgotOtp(string $email, string $otp)
    {
        $stmt = $this->userConn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return 'user_not_found';
        }

        $userId = (int)$user['id'];

        $stmt = $this->resetOtpConn->prepare("SELECT * FROM reset_password_otp WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $otpRow = $stmt->get_result()->fetch_assoc();

        if (!$otpRow) {
            return 'otp_not_found';
        }

        if ((int)$otpRow['attempts'] >= 3) {
            return 'max_attempts';
        }

        if (date('Y-m-d H:i:s') > $otpRow['expires_at']) {
            return 'expired';
        }

        if ($otpRow['otp'] != $otp) {
            $otpCount = $this->resetOtpConn->prepare("UPDATE reset_password_otp SET attempts = attempts + 1 WHERE user_id = ?");
            $otpCount->bind_param("i", $userId);
            $otpCount->execute();

            return 'wrong_otp';
        }
        return 'success';
    }

    public function resetPassword(string $email, string $otp, string $newPassword)
    {
        $otpStatus = $this->verifyFOrgotOtp($email, $otp);
        if ($otpStatus !== 'success') {
            return $otpStatus;
        }

        $stmt = $this->userConn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return 'user_not_found';
        }

        $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updatePassword = $this->userConn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updatePassword->bind_param("si", $hashPassword, $user['id']);
        $updatePassword->execute();

        $deletePassword = $this->resetOtpConn->prepare("DELETE FROM reset_password_otp WHERE user_id = ?");
        $deletePassword->bind_param("i", $user['id']);
        $deletePassword->execute();

        return 'success';
    }
}
