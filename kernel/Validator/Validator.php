<?php

namespace App\Kernel\Validator;

/**
 * The Validator class is responsible for validating data based on given rules.
 */
class Validator implements ValidatorInterface
{
    private array $errors = [];

    private array $data;

    public static function generateRule(bool $required = false, ?int $min = null, ?int $max = null, bool $email = false, bool $confirmed = false): array
    {
        $rule = [];

        if ($required) {
            $rule[] = 'required';
        }

        if ($min) {
            $rule[] = "min:$min";
        }

        if ($max) {
            $rule[] = "max:$max";
        }

        if ($email) {
            $rule[] = 'email';
        }

        if ($confirmed) {
            $rule[] = 'confirmed';
        }

        return $rule;
    }

    /**
     * Validates the given data based on the provided rules.
     *
     * Keys in data array should match keys in rulesAssoc array
     *
     * You can use Validator::generateRule() to generate rules for rulesAssoc array values
     *
     * Possible validation rules:
     * - [required] The field is required.
     * - [min:length] The field must be at least a given length.
     * - [max:length] The field must be at most a given length.
     * - [email] The field must be a valid email address.
     * - [confirmed] The field must be confirmed.
     *
     * Returns true if the data passes all the validation rules, false otherwise.
     * The validation errors can be retrieved using the errors method.
     *
     * usage:
     *
     * $validator = new Validator();
     * $data = [
     *    'name' => 'John Doe',
     *    'email' => 'poo@poo.com'
     * ];
     * $rulesAssoc = [
     *   'name' => Validator::generateRule(required:true, min:3, max:255);,
     *   'email' => Validator::generateRule(required:true, max:255, email:true)
     * ];
     * $validator->validate($data, $rulesAssoc);
     *
     * @param  array  $data  The data to be validated.
     * @param  array  $rules  The validation rules.
     * @return bool Returns true if the data passes all the validation rules, false otherwise.
     */
    public function validate(array $data, array $rulesAssoc): bool
    {
        $this->errors = [];
        $this->data = $data;

        foreach ($rulesAssoc as $key => $rules) {
            foreach ($rules as $rule) {
                $rule = explode(':', $rule);

                $ruleName = $rule[0];
                $ruleValue = $rule[1] ?? null;

                $error = $this->validateRule($key, $ruleName, $ruleValue);

                if ($error) {
                    $this->errors[$key][] = $error;
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Get the validation errors.
     *
     * @return array The validation errors.
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Validates a single rule for a given key and value.
     *
     * @param  string  $dataKey  The key of the data to be validated.
     * @param  string  $ruleName  The name of the validation rule.
     * @param  string|null  $ruleValue  The value associated with the validation rule.
     * @return string|false Returns an error message if the validation fails, false otherwise.
     */
    private function validateRule(string $dataKey, string $ruleName, ?string $ruleValue = null): string|false
    {
        $dataValue = $this->data[$dataKey];

        switch ($ruleName) {
            case 'required':
                if (empty($dataValue)) {
                    return "Field $dataKey is required";
                }
                break;
            case 'min':
                if (strlen($dataValue) < $ruleValue) {
                    return "Field $dataKey must be at least $ruleValue characters long";
                }
                break;
            case 'max':
                if (strlen($dataValue) > $ruleValue) {
                    return "Field $dataKey must be at most $ruleValue characters long";
                }
                break;
            case 'email':
                if (! filter_var($dataValue, FILTER_VALIDATE_EMAIL)) {
                    return "Field $dataKey must be a valid email address";
                }
                break;
            case 'confirmed':
                if ($dataValue !== $this->data["{$dataKey}_confirmation"]) {
                    return "Field $dataKey must be confirmed";
                }
                break;
        }

        return false;
    }
}
