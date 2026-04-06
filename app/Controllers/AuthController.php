<?php

namespace Vendor\App\Controllers;

use Vendor\App\Core\Controller;
use Vendor\App\Services\AuthService;
use Vendor\App\Validation\RegisterValidation;
use Vendor\App\Validation\LoginValidation;
use Vendor\App\Validation\ForgotValidation;
use Exception;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLanding(): void
    {
        $this->view('landing');
    }

    public function showRegister()
    {
        $this->view('auth/register', ['errors' => [], 'old' => []]);
    }

    public function register(): void
    {
        try {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $old = ['name'  => $name, 'email' => $email, 'phone' => $phone, 'city'  => $city,];

            $validator = new RegisterValidation();
            $errors = $validator->validate($name, $email, $phone, $city, $password);

            if (!empty($errors)) {
                $this->view('auth/register', [
                    'errors' => $errors,
                    'old' => $old,
                ]);
                return;
            }

            $result = $this->authService->register($name, $email, $phone, $city, $password);

            if ($result['status'] === 'exists') {
                $this->view('auth/register', [
                    'errors' => ['This email is already registered.'],
                    'old' => $old,
                ]);
                return;
            }

            $_SESSION['otp_email'] = $result['email'];

            $sent = !empty($result['sent']);
            if ($sent && ($result['status'] ?? '') === 'resend') {
                $message = 'OTP resent to ' . $result['email'] . '. Check your inbox.';
            } elseif ($sent) {
                $message = 'OTP sent to ' . $result['email'] . '. Check your inbox.';
            } else {
                $message = 'Registered! But email failed. Please resend OTP.';
            }

            $_SESSION['otp_message'] = $message;
            header("Location: /verify-otp");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/register', [
                'errors' => ['Something went wrong. Please try again.'],
                'old' => [],
            ]);
        }
    }

    public function showVerifyOtp(): void
    {
        if (empty($_SESSION['otp_email'])) {
            header("Location: /register");
            exit;
        }

        $message = $_SESSION['otp_message'] ?? '';
        unset($_SESSION['otp_message']);

        $this->view('auth/verify_otp', [
            'email' => $_SESSION['otp_email'],
            'errors' => [],
            'message' => $message,
        ]);
    }

    public function verifyOtp(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $otp = trim($_POST['otp'] ?? '');

            if (empty($email) || empty($otp)) {
                $this->view('auth/verify_otp', [
                    'email' => $email,
                    'errors' => ['OTP and email are required.'],
                    'message' => '',
                ]);
                return;
            }

            $result = $this->authService->verifyOtp($email, $otp);

            if ($result === 'success') {
                unset($_SESSION['otp_email']);
                header("Location: /login?msg=verified");
                exit;
            }

            $errors = [
                'wrong_otp' => 'Incorrect OTP. Please try again.',
                'expired' => 'OTP has expired. Please request a new one.',
                'max_attempts' => 'Too many wrong attempts. Please resend OTP.',
                'otp_not_found' => 'No OTP found. Please resend.',
                'user_not_found' => 'User not found.',
            ];

            $error = $errors[$result] ?? 'Something went wrong.';

            $this->view('auth/verify_otp', [
                'email' => $email,
                'errors' => [$error],
                'message' => '',
            ]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/verify_otp', [
                'email' => $_POST['email'] ?? '',
                'errors' => ['Something went wrong.'],
                'message' => '',
            ]);
        }
    }

    public function resendOtp(): void
    {
        try {
            $email = trim($_POST['email']);

            if (empty($email)) {
                header("Location: /register");
                exit;
            }

            $result = $this->authService->resendOtp($email);

            if ($result === 'sent') {
                $_SESSION['otp_email'] = $email;
                $_SESSION['otp_message'] = 'New OTP sent to ' . $email;
                header("Location: /verify-otp");
                exit;
            }

            if ($result === 'already_verified') {
                header("Location: /login?msg=verified");
                exit;
            }

            $_SESSION['otp_email'] = $email;
            $_SESSION['otp_message'] = 'Failed to send OTP. Try again.';
            header("Location: /verify-otp");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            header("Location: /register");
            exit;
        }
    }

    public function showLogin(): void
    {
        $msg = $_GET['msg'] ?? '';
        $success = '';

        if ($msg === 'verified') {
            $success = 'Email verified! You can now log in.';
        }

        if ($msg === 'password_reset') {
            $success = 'Password reset successful! Please log in.';
        }

        $this->view('auth/login', [
            'errors' => [],
            'success' => $success,
        ]);
    }

    public function login(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $validator = new LoginValidation();
            $errors = $validator->validate($email, $password);

            if (!empty($errors)) {
                $this->view('auth/login', [
                    'errors' => $errors,
                    'success' => '',
                ]);
                return;
            }

            $result = $this->authService->login($email, $password);

            if (is_string($result)) {
                $errorMap = [
                    'not_found' => 'No account found with this email.',
                    'wrong_password' => 'Incorrect password.',
                    'unverified' => 'Please verify your email first.',
                ];

                $error = $errorMap[$result] ?? 'Login failed.';

                if ($result === 'unverified') {
                    $_SESSION['otp_email'] = $email;
                }

                $this->view('auth/login', [
                    'errors' => [$error],
                    'success' => '',
                    'unverified' => $result === 'unverified',
                    'email' => $email,
                ]);
                return;
            }

            $_SESSION['user'] = [
                'id' => $result['id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'city' => $result['city'],
                'phone' => $result['phone'],
            ];

            header("Location: /dashboard");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/login', [
                'errors' => ['Something went wrong.'],
                'success' => '',
            ]);
        }
    }

    public function showForgotPassword(): void
    {
        $this->view('auth/forgot_password', [
            'errors' => [],
            'success' => '',
        ]);
    }

    public function forgotPassword(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');

            $validator = new ForgotValidation();
            $errors = $validator->validateEmail($email);

            if (!empty($errors)) {
                $this->view('auth/forgot_password', [
                    'errors' => $errors,
                    'success' => '',
                ]);
                return;
            }

            $result = $this->authService->sendForgotOtp($email);

            if ($result === 'not_found') {
                $this->view('auth/forgot_password', [
                    'errors' => ['No account found with this email.'],
                    'success' => '',
                ]);
                return;
            }

            if ($result === 'mail_failed') {
                $this->view('auth/forgot_password', [
                    'errors' => ['Failed to send OTP. Try again.'],
                    'success' => '',
                ]);
                return;
            }

            $_SESSION['reset_email'] = $email;
            header("Location: /reset-password");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/forgot_password', [
                'errors' => ['Something went wrong.'],
                'success' => '',
            ]);
        }
    }

    public function showResetPassword(): void
    {
        if (empty($_SESSION['reset_email'])) {
            header("Location: /forgot-password");
            exit;
        }

        $this->view('auth/reset_password', [
            'email' => $_SESSION['reset_email'],
            'errors' => [],
            'success' => '',
        ]);
    }

    public function resetPassword(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $otp = trim($_POST['otp'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            $validator = new ForgotValidation();
            $errors = $validator->validateReset($otp, $password, $confirmPassword);

            if (!empty($errors)) {
                $this->view('auth/reset_password', [
                    'email' => $email,
                    'errors' => $errors,
                    'success' => '',
                ]);
                return;
            }

            $result = $this->authService->resetPassword($email, $otp, $password);

            if ($result === 'success') {
                unset($_SESSION['reset_email']);
                header("Location: /login?msg=password_reset");
                exit;
            }

            $errorMap = [
                'wrong_otp' => 'Incorrect OTP.',
                'expired' => 'OTP has expired. Please request a new one.',
                'max_attempts' => 'Too many wrong attempts.',
                'otp_not_found' => 'OTP not found. Please request again.',
            ];

            $error = $errorMap[$result] ?? 'Something went wrong.';

            $this->view('auth/reset_password', [
                'email' => $email,
                'errors' => [$error],
                'success' => '',
            ]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/reset_password', [
                'email' => $_POST['email'] ?? '',
                'errors' => ['Something went wrong.'],
                'success' => '',
            ]);
        }
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
