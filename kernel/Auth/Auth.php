<?php

namespace App\Kernel\Auth;

use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Database\DataModels\UserModel;
use App\Kernel\Session\SessionInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private DatabaseInterface $db,
        private SessionInterface $session,
        private ConfigInterface $config,
    ) {
    }

    public function attempt(string $login, string $password): bool
    {
        $user = $this->db->first($this->table(), [$this->login() => $login]);

        if (!$user) {

            return false;
        }
        // TODO: password_verify for hashing
        if ($password != $user[$this->password()]) {
            return false;
        }
        $this->session->set($this->sessionField(), $user['id_user']);

        return true;
    }

    public function logout(): void
    {
        $this->session->remove($this->sessionField());
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has($this->sessionField());
    }

    public function currUser(): ?UserModel
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return $this->getUserById($this->session->get($this->sessionField()));
    }
    public function getUserById(string $id = null): ?UserModel
    {
        if (empty($id)) {
            return null;
        }

        $userData = $this->db->first(
            $this->table(),
            ['id_user' => $id]
        );

        return UserModel::createFromArray($userData);
    }

    /**
     * @return ?array<string, ?UserModel>
     */
    public function allUsers(): ?array
    {
        $usersData = $this->db->get($this->table());
        return array_map(
            fn($userData) => UserModel::createFromArray($userData),
            $usersData
        );
    }

    public function isAdmin(): ?bool
    {
        $user = $this->currUser();
        if (!isset($user)) {
            return null;
        }

        return $user->type == 'admin';
    }

    public function setAttemptError(): void
    {
        $this->session->set('attempt.error', ['Invalid login or password']);
    }

    public function table(): string
    {
        return $this->config->get('auth.table');
    }

    public function login(): string
    {
        return $this->config->get('auth.login');
    }

    public function password(): string
    {
        return $this->config->get('auth.password');
    }

    public function sessionField(): string
    {
        return $this->config->get('auth.sessionField');
    }
}
