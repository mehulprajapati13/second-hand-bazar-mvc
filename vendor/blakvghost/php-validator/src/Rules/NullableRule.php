<?php

/**
 * NullableRule - A validation rule implementation for checking if a field's value is nullable.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabiroualassane.link
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\Contracts\Rule;
use BlakvGhost\PHPValidator\Lang\LangManager;

class NullableRule implements Rule
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the NullableRule class.
     *
     * @param array $parameters Parameters for the rule, not used in this rule.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if a field's value is nullable.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True always, nullable does not fail validation itself.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Nullable never fails by itself
        return true;
    }

    /**
     * Get the validation error message for the nullable rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation message
        return LangManager::getTranslation('validation.nullable_rule', [
            'attribute' => $this->field,
        ]);
    }
}
