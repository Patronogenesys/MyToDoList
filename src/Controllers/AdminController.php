<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class AdminController extends Controller
{
    public function index(): void
    {
        $users = $this->auth->allUsers();

        $this->session->set('auth.allUsers', $users);

        $this->view->page('admin');
    }

    public function deleteUser(): void
    {
        $id = $this->request->getMethodValue('user');
        $this->database->delete('users', ['id_user' => $id]);
        $this->redirect('/admin');
    }

    public function switchUserType(): void
    {
        $id = $this->request->getMethodValue('user');
        $isAdmin = $this->auth->getUserById($id)->type == 'admin';
        $this->database->update('users', ['type' => $isAdmin ? 'user' : 'admin'], ['id_user' => $id]);
        $this->redirect('/admin');
    }
}
