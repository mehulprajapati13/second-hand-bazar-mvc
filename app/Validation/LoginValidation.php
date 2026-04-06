<?php

namespace Vendor\App\Validation;

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

class LoginValidation
{
    public function validate(string $email, string $password): array
    {
        try {
            $data = [
                'email' => $email,
                'password' => $password,
            ];

            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];

            $messages = [
                'email' => [
                    'required' => 'Email is required.',
                    'email' => 'Please enter a valid email.',
                ],
                'password' => [
                    'required' => 'Password is required.',
                    'min' => 'Password must be at least 6 characters.',
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
}