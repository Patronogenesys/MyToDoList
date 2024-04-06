<?php

namespace App\Kernel\Router;

use App\Kernel\Auth\AuthInterface;
use App\Kernel\Controller\Controller;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Http\RedirectInterface;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Session\SessionInterface;
use App\Kernel\View\ViewInterface;

/**
 * Class Router
 * Обработака запроса и вызов контроллера в зависимости от URI, обращаясь к списку маршрутов;
 */
class Router implements RouterInterface
{
    private array $routes = [
        Methods::GET => [],
        Methods::POST => [],
    ];

    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,

    ) {
        $this->initRoutes();
    }

    /**
     * Отправляет запрос на соответствующий маршрут.
     *
     * Этот метод отвечает за поиск правильного маршрута на основе предоставленного URI и метода.
     * Если маршрут найден, он извлекает действие, связанное с маршрутом.
     * Если действие представляет собой массив, он предполагает, что первый элемент - это контроллер, а второй - метод этого контроллера.
     * Затем он создает экземпляр контроллера, устанавливает представление и обновляет действие, чтобы оно было вызываемым массивом.
     * Наконец, он вызывает действие (либо замыкание, либо метод контроллера).
     *
     * Если маршрут не найден, он вызывает метод `onPageNotFound`.
     *
     * @param  string  $uri  URI запроса.
     * @param  string  $method  HTTP-метод запроса.
     */
    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);



        if (!$route) {
            $this->onPageNotFound();

            return;
        }

        $action = $route->getAction();

        /**
         * @var Controller $controller
         */
        if (is_array($action)) {
            [$Controller, $Action] = $route->getAction();

            $controller = new $Controller(
                $this->view,
                $this->request,
                $this->redirect,
                $this->session,
                $this->database,
                $this->auth,
            );

            $action = [$controller, $Action];
        }

        call_user_func($action);
    }

    /**
     *  Этот метод инициализирует маршруты, извлекая их из файла конфигурации и сохраняя их в массиве `$routes`.
     */
    private function initRoutes()
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    /**
     * @return Route[]
     */
    private function getRoutes(): array
    {
        return require_once APP_PATH . '/config/routes.php';
    }

    private function findRoute(string $uri, $method): Route|false
    {
        $route = isset($this->routes[$method][$uri]) ? $this->routes[$method][$uri] : null;

        if (empty($route)) {
            return false;
        }

        return $route;
    }

    private function onPageNotFound(): void
    {

        $route = $this->findRoute('/404', Methods::GET);

        if (!$route) {
            throw new \Exception('404 route not found');
        }

        $action = $route->getAction();

        [$Controller, $Action] = $route->getAction();

        $controller = new $Controller();

        call_user_func([$controller, 'setView'], $this->view);
        $action = [$controller, $Action];

        call_user_func($action);
    }
}
