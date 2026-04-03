<?php

namespace Vendor\App\Validation;

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

class ForgotValidation
{
    public function validateEmail(string $email): array
    {
        try {
            $data = ['email' => $email];
            $rules = ['email' => 'required|email'];
            $messages = [
                'email' => [
                    'required' => 'Email is required.',
                    'email' => 'Please enter a valid email.',
                ],
            ];

            $validator = new Validator($data, $rules, $messages);

            if (!$validator->isValid()) {
                return array_merge(...array_values($validator->getErrors()));
            }

            return [];

        } catch (ValidatorException $e) {
            return [$e->getMessage()];
        }
    }

    public function validateReset(
        string $otp,
        string $password,
        string $confirmPassword
    ): array {
        try {
            $data = [
                'otp' => $otp,
                'password' => $password,
                'confirm_password' => $confirmPassword,
            ];

            $rules = [
                'otp' => 'required|min:6|max:6',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6',
            ];

            $messages = [
                'otp' => [
                    'required' => 'OTP is required.',
                    'min' => 'OTP must be 6 digits.',
                    'max' => 'OTP must be 6 digits.',
                ],
                'password' => [
                    'required' => 'New password is required.',
                    'min' => 'Password must be at least 6 characters.',
                ],
                'confirm_password' => [
                    'required' => 'Please confirm your password.',
                    'min' => 'Password must be at least 6 characters.',
                ],
            ];

            $validator = new Validator($data, $rules, $messages);

            if (!$validator->isValid()) {
                return array_merge(...array_values($validator->getErrors()));
            }

            if ($password !== $confirmPassword) {
                return ['Passwords do not match.'];
            }

            return [];

        } catch (ValidatorException $e) {
            return [$e->getMessage()];
        }
    }
}