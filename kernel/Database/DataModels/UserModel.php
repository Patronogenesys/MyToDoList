<?php

namespace App\Kernel\Database\DataModels;

class UserModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly string $password,
        public readonly string $name,
        public readonly string $email,
        public readonly string $type,
    ) {
    }

    public static function createFromArray(array $data): ?self
    {
        if (empty($data["id_user"]) || empty($data["login"]) || empty($data["password"]) || empty($data["name"]) || empty($data["email"]) || empty($data["type"])) {
            return null;
        }
        return new self(
            id: $data["id_user"],
            login: $data["login"],
            password: $data["password"],
            name: $data["name"],
            email: $data["email"],
            type: $data["type"]
        );
    }
}
