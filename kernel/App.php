<?php

namespace App\Kernel;

use App\Kernel\DI\DIContainer;

class App
{
    private DIContainer $container;

    public function __construct()
    {
        $this->container = new DIContainer();
    }

    public function run(): void
    {
        $this
            ->container
            ->router
            ->dispatch(
                $this->container->request->uri(),
                $this->container->request->method()
            );
    }
}
