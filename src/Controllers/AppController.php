<?php

namespace App\Controllers;

use App\Kernel\Auth\Auth;
use App\Kernel\Auth\AuthInterface;
use App\Kernel\Controller\Controller;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\RedirectInterface;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Session\SessionInterface;
use App\Kernel\View\ViewInterface;
use App\Services\TaskService;

class AppController extends Controller
{

    private TaskService $taskService;

    public function __construct(
        ?ViewInterface $view = null,
        ?RequestInterface $request = null,
        ?RedirectInterface $redirect = null,
        ?SessionInterface $session = null,
        ?DatabaseInterface $database = null,
        ?AuthInterface $auth = null,
    ) {
        parent::__construct($view, $request, $redirect, $session, $database, $auth);
        $this->taskService = new TaskService($this->database);
    }
    public function index(): void
    {
        $this->view->page('app');
    }

    public function getAllTasks(): void
    {

        // Устанавливаем заголовок
        header('Content-Type: application/json');


        //обработка ошибок
        $logined = isset($this->auth->currUser()->id);

        if (!$logined) {
            $this->handleAuthError();
        }

        // Получаем данные
        $userId = $this->auth->currUser()->id;
        $response = $this->taskService->getAllTasksByUserId($userId);


        // Отправляем ответ
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function updateAllTasks(): void
    {
        $logined = isset($this->auth->currUser()->id);

        if (!$logined) {
            $this->handleAuthError();
        }

        $jsonData = json_decode(file_get_contents("php://input"), true);
        $userId = $this->auth->currUser()->id;

        $response = $this->taskService->updateAllTasksByUserId($userId, $jsonData);

        // Устанавливаем заголовок
        header('Content-Type: application/json');

        // Отправляем ответ
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function handleAuthError(): void
    {

        http_response_code(400); // Устанавливаем код состояния
        $error = array(
            'error' => array(
                'code' => 400,
                'message' => 'Пользователь не авторизован'
            )
        );
        echo json_encode($error, JSON_UNESCAPED_UNICODE);
        exit();
    }
}


