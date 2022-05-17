<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Controller;
use App\Controller\Error;
use App\Controller\Game;

class Router
{
    public array $routes = [
        '/' => Game::class,
        '/404' => Error::class,
    ];
    private string $path;

    public function __construct()
    {
        $this->path = $_SERVER['PATH_INFO'] ?? '/';
    }

    public function getController(): Controller
    {
        $controllerClass = $this->routes[$this->path] ?? $this->routes['/404'];
        $controller = new $controllerClass();

        if (!$controller instanceof Controller) {
            throw new \LogicException("Controller $controller should implement".Controller::class);
        }

        return $controller;
    }
}
