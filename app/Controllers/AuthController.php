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
    private const REGISTER_FORM_FLASH = 'register_form_flash';
    private const LOGIN_FORM_FLASH = 'login_form_flash';
    private const FORGOT_FORM_FLASH = 'forgot_form_flash';

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    private function pullFormFlash(string $key): array
    {
        $flash = $_SESSION[$key] ?? [];
        unset($_SESSION[$key]);
        return is_array($flash) ? $flash : [];
    }

    public function showLanding(): void
    {
        $this->view('landing');
    }

    public function showRegister()
    {
        $flash = $this->pullFormFlash(self::REGISTER_FORM_FLASH);
        $this->view('auth/register', [
            'errors' => $flash['errors'] ?? [],
            'old' => $flash['old'] ?? [],
        ]);
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
                $_SESSION[self::REGISTER_FORM_FLASH] = [
                    'errors' => $errors,
                    'old' => $old,
                ];
                header("Location: /register");
                exit;
            }

            $result = $this->authService->register($name, $email, $phone, $city, $password);

            if ($result['status'] === 'exists') {
                $_SESSION[self::REGISTER_FORM_FLASH] = [
                    'errors' => ['email' => 'This email is already registered.'],
                    'old' => $old,
                ];
                header("Location: /register");
                exit;
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
            $_SESSION[self::REGISTER_FORM_FLASH] = [
                'errors' => ['_general' => 'Something went wrong. Please try again.'],
                'old' => [],
            ];
            header("Location: /register");
            exit;
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
                    'errors' => ['otp' => 'OTP is required.'],
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
                'errors' => ['_general' => $error],
                'message' => '',
            ]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/verify_otp', [
                'email' => $_POST['email'] ?? '',
                'errors' => ['_general' => 'Something went wrong.'],
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
        $flash = $this->pullFormFlash(self::LOGIN_FORM_FLASH);
        $msg = $_GET['msg'] ?? '';
        $success = '';

        if ($msg === 'verified') {
            $success = 'Email verified! You can now log in.';
        }

        if ($msg === 'password_reset') {
            $success = 'Password reset successful! Please log in.';
        }

        $this->view('auth/login', [
            'errors' => $flash['errors'] ?? [],
            'success' => $success,
            'unverified' => !empty($flash['unverified']),
            'email' => $flash['email'] ?? '',
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
                $_SESSION[self::LOGIN_FORM_FLASH] = [
                    'errors' => $errors,
                    'email' => $email,
                ];
                header("Location: /login");
                exit;
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

                $_SESSION[self::LOGIN_FORM_FLASH] = [
                    'errors' => ['_general' => $error],
                    'unverified' => $result === 'unverified',
                    'email' => $email,
                ];
                header("Location: /login");
                exit;
            }

            $_SESSION['user'] = [
                'id' => $result['id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'city' => $result['city'],
                'phone' => $result['phone'],
                'role' => $result['role'],  
            ];

            if (($_SESSION['user']['role'] ?? '') === 'admin') {
                header("Location: /admin/dashboard");
                exit;
            }

            header("Location: /dashboard");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $_SESSION[self::LOGIN_FORM_FLASH] = [
                'errors' => ['_general' => 'Something went wrong.'],
                'email' => trim($_POST['email'] ?? ''),
            ];
            header("Location: /login");
            exit;
        }
    }

    public function showForgotPassword(): void
    {
        $flash = $this->pullFormFlash(self::FORGOT_FORM_FLASH);
        $this->view('auth/forgot_password', [
            'errors' => $flash['errors'] ?? [],
            'success' => $flash['success'] ?? '',
            'email' => $flash['email'] ?? '',
        ]);
    }

    public function forgotPassword(): void
    {
        try {
            $email = trim($_POST['email'] ?? '');

            $validator = new ForgotValidation();
            $errors = $validator->validateEmail($email);

            if (!empty($errors)) {
                $_SESSION[self::FORGOT_FORM_FLASH] = [
                    'errors' => $errors,
                    'success' => '',
                    'email' => $email,
                ];
                header("Location: /forgot-password");
                exit;
            }

            $result = $this->authService->sendForgotOtp($email);

            if ($result === 'not_found') {
                $_SESSION[self::FORGOT_FORM_FLASH] = [
                    'errors' => ['email' => 'No account found with this email.'],
                    'success' => '',
                    'email' => $email,
                ];
                header("Location: /forgot-password");
                exit;
            }

            if ($result === 'mail_failed') {
                $_SESSION[self::FORGOT_FORM_FLASH] = [
                    'errors' => ['_general' => 'Failed to send OTP. Try again.'],
                    'success' => '',
                    'email' => $email,
                ];
                header("Location: /forgot-password");
                exit;
            }

            $_SESSION['reset_email'] = $email;
            header("Location: /reset-password");
            exit;
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $_SESSION[self::FORGOT_FORM_FLASH] = [
                'errors' => ['_general' => 'Something went wrong.'],
                'success' => '',
                'email' => trim($_POST['email'] ?? ''),
            ];
            header("Location: /forgot-password");
            exit;
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
                'errors' => ['_general' => $error],
                'success' => '',
            ]);
        } catch (Exception $e) {
            $this->log($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine(),]);
            $this->view('auth/reset_password', [
                'email' => $_POST['email'] ?? '',
                'errors' => ['_general' => 'Something went wrong.'],
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
