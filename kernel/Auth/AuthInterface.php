<?php

namespace App\Kernel\Auth;

use App\Kernel\Database\DataModels\UserModel;

interface AuthInterface
{
    public function attempt(string $login, string $password): bool;

    public function setAttemptError(): void;

    public function logout(): void;

    public function isLoggedIn(): bool;

    public function currUser(): ?UserModel;

    public function getUserById(string $id): ?UserModel;


    /**
     * @return ?UserModel[]|null
     */
    public function allUsers(): ?array;

    public function isAdmin(): ?bool;

    public function table(): string;

    public function login(): string;

    public function password(): string;
}
