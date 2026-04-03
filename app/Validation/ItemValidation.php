<?php

namespace Vendor\App\Validation;

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;

class ItemValidation
{
    public function validate(
        string $title,
        string $description,
        string $price,
        string $mode,
        string $city
    ): array {

        try {
            $data = [
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'mode' => $mode,
                'city' => $city,
            ];

            $rules = [
                'title' => 'required|string',
                'description' => 'required|string',
                'price' => 'required',
                'mode' => 'required',
                'city' => 'required|string',
            ];

            $messages = [
                'title' => ['required' => 'Title is required.'],
                'description' => ['required' => 'Description is required.'],
                'price' => ['required' => 'Price is required.'],
                'mode' => ['required' => 'Please select sell or rent.'],
                'city' => ['required' => 'City is required.'],
            ];

            $validator = new Validator($data, $rules, $messages);

            if (!$validator->isValid()) {
                return array_merge(...array_values($validator->getErrors()));
            }

            if (!is_numeric($price) || (float)$price <= 0) {
                return ['Price must be a valid positive number.'];
            }

            if (!in_array($mode, ['sell', 'rent'])) {
                return ['Mode must be sell or rent.'];
            }

            return [];
        } catch (ValidatorException $e) {
            return [$e->getMessage()];
        }
    }
}
