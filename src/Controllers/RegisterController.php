<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Validator\Validator;

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view->page('register');
    }

    public function register(): void
    {
        $rules = [
            'name' => Validator::generateRule(required: true, min: 3, max: 255),
            'email' => Validator::generateRule(required: true),
            'login' => Validator::generateRule(required: true, min: 3, max: 255),
            'password' => Validator::generateRule(required: true, min: 8),
        ];
        $validation = $this->request->validate($rules);

        if (! $validation) {
            $this->setValidationErrors();
            $this->redirect('/register');
        }

        $id = $this->database->insert('users', [
            'name' => $this->request->getMethodValue('name'),
            'email' => $this->request->getMethodValue('email'),
            'login' => $this->request->getMethodValue('login'),
            // TODO: Hash password
            'password' => $this->request->getMethodValue('password'),
        ]);

        if (! $id) {
            dd('User not registered: DATABASE ERROR');
        }

        dd('User succesfully registered with id: ', $id);
    }
}
