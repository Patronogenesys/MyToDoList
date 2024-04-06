<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class PageNotFoundController extends Controller
{
    public function index(): void
    {
        $this->view->page('404');
    }
}
