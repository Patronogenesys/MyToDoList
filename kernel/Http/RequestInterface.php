<?php

namespace App\Kernel\Http;

use App\Kernel\Validator\ValidatorInterface;

interface RequestInterface
{
    public static function createFromGolbals(): self;

    public function uri(): string;

    public function method(): string;

    public function getMethodValue(string $key, ?string $default = null): ?string;

    // TODO: Вынести в отдельный интерфейс RequestValidatorInterface и реализовать в классе RequestValidator
    public function validate(array $rules): bool;

    public function validationErrors(): array;

    public function setValidator(ValidatorInterface $validator): void;
}
