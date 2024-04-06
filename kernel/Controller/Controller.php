<?php

namespace App\Kernel\Controller;

use App\Kernel\Auth\AuthInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\RedirectInterface;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Session\SessionInterface;
use App\Kernel\View\ViewInterface;

abstract class Controller
{
    public function __construct(
        protected ?ViewInterface $view = null,
        protected ?RequestInterface $request = null,
        protected ?RedirectInterface $redirect = null,
        protected ?SessionInterface $session = null,
        protected ?DatabaseInterface $database = null,
        protected ?AuthInterface $auth = null,
    ) {
        $this->setView($view);
        $this->setRequest($request);
        $this->setRedirect($redirect);
        $this->setSession($session);
        $this->setDatabase($database);
        $this->setAuth($auth);
    }

    public function redirect(string $url): void
    {
        $this->redirect->to($url);
    }

    public function setView($view)
    {
        if (! $view) {
            return;
        }
        $this->view = $view;
    }

    public function setRequest($request)
    {
        if (! $request) {
            return;
        }
        $this->request = $request;
    }

    public function setRedirect($redirect)
    {
        if (! $redirect) {
            return;
        }
        $this->redirect = $redirect;
    }

    public function setSession($session)
    {
        if (! $session) {
            return;
        }
        $this->session = $session;
    }

    public function setDatabase($database)
    {
        if (! $database) {
            return;
        }
        $this->database = $database;
    }

    public function setAuth($auth)
    {
        if (! $auth) {
            return;
        }
        $this->auth = $auth;
    }

    public function setValidationErrors(): void
    {
        foreach ($this->request->validationErrors() as $key => $errors) {
            $this->session->set("$key.errors", $errors);
        }
    }
}
