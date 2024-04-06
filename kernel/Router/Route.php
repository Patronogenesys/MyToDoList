<?php

namespace App\Kernel\Router;

class Route
{
    public function __construct(
        private string $uri,
        private string $method,
        private $action
    ) {

    }

    public static function createGet(string $uri, $action)
    {
        return new static($uri, Methods::GET, $action);
    }

    public static function createPost(string $uri, $action)
    {
        return new static($uri, Methods::POST, $action);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }
}
