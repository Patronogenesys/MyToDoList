<?php

namespace App\Kernel\Validator;

/**
 * The Validator class is responsible for validating data based on given rules.
 */
interface ValidatorInterface
{
    public static function generateRule(bool $required = false, ?int $min = null, ?int $max = null, bool $email = false, bool $confirmed = false): array;

    public function validate(array $data, array $rulesAssoc): bool;

    public function errors(): array;
}
