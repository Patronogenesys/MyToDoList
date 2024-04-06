<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Validator\Validator;

class LogInController extends Controller
{
    public function index(): void
    {
        $this->view->page('login');
    }

    public function login(): void
    {
        $rules = [
            'login' => Validator::generateRule(required: true),
            'password' => Validator::generateRule(required: true),
        ];
        $validation = $this->request->validate($rules);

        if (!$validation) {
            $this->setValidationErrors();
            $this->redirect('/login');
        }

        $attempt = $this->auth->attempt($this->request->getMethodValue('login'), $this->request->getMethodValue('password'));
        if (!$attempt) {
            $this->auth->setAttemptError();
            $this->redirect('/login');
        }
        if ($this->auth->isAdmin()) {
            $this->redirect('/admin');
        }
        $this->redirect('/home');
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/home');
    }
}
