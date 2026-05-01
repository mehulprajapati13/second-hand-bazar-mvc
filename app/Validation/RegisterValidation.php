<?php

namespace Vendor\App\Validation;

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

class RegisterValidation
{
    public function validate(string $name, string $email, string $phone, string $city, string $password): array 
    {

        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'password' => $password,
            ];

            $rules = [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|min:10|max:10',
                'city' => 'required|string',
                'password' => 'required|min:8',
            ];

            $messages = [
                'name' => [
                    'required' => 'Name is required.',
                    'string' => 'Name must be text.',
                ],
                'email' => [
                    'required' => 'Email is required.',
                    'email' => 'Please enter a valid email.',
                ],
                'phone' => [
                    'required' => 'Phone number is required.',
                    'min' => 'Phone must be exactly 10 digits.',
                    'max' => 'Phone must be exactly 10 digits.',
                ],
                'city' => [
                    'required' => 'City is required.',
                    'string' => 'City must be text.',
                ],
                'password' => [
                    'required' => 'Password is required.',
                    'min' => 'Password must be at least 8 characters.',
                ],
            ];

            $validator = new Validator($data, $rules, $messages);

            if (!$validator->isValid()) {
                // Return keyed errors: ['field_name' => 'First error for that field']
                $keyed = [];
                foreach ($validator->getErrors() as $field => $fieldErrors) {
                    $keyed[$field] = $fieldErrors[0] ?? '';
                }
                return $keyed;
            }

            return [];

        } catch (ValidatorException $e) {
            return ['_general' => $e->getMessage()];
        }
    }
}