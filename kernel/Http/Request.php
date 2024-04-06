<?php

namespace App\Kernel\Http;

use App\Kernel\Validator\ValidatorInterface;

class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $files,
        public readonly array $cookies,
    ) {
    }

    public static function createFromGolbals(): self
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * Возвращает значение параметра запроса POST или GET по ключу.
     *
     * Если параметр с указанным ключом не найден, возвращает значение по умолчанию.
     *
     * @param  string  $key  Ключ параметра запроса.
     * @param  string|null  $default  Значение по умолчанию, возвращаемое если параметр не найден.
     * @return string|null Значение параметра запроса или значение по умолчанию, если параметр не найден.
     */
    public function getMethodValue(string $key, ?string $default = null): ?string
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function validate(array $rules): bool
    {
        $data = [];

        foreach ($rules as $key => $rule) {
            $data[$key] = $this->getMethodValue($key);
        }

        return $this->validator->validate($data, $rules);
    }

    public function validationErrors(): array
    {
        return $this->validator->errors();
    }

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function validator(): ValidatorInterface
    {
        return $this->validator;
    }
}
