<?php

namespace App\Core;

class Router
{
    private $routes = [];
    private $middleware = [];

    public function __construct()
    {
        $this->routes = require APP . '/config/routes.php';
        $this->middleware = require APP . '/config/middleware.php';
    }

    public function match()
    {
        $url = $this->getUrl();
        $req_method = $this->getRequestMethod();

        foreach ($this->routes as $route) {
            if ($this->isMatchingRoute($route, $url, $req_method)) {
                $this->handleRoute($route);
                return;
            }
        }

        $this->handleNotFound($url);
    }

    private function getUrl()
    {
        return strtolower('/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    }

    private function getRequestMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    private function isMatchingRoute($route, $url, $req_method)
    {
        return strtolower($route['pattern']) === $url && strtolower($route['method']) === $req_method;
    }

    private function handleRoute($route)
    {
        if (array_key_exists('action', $route)) {
            $this->dispatch($route);
        }
    }

    private function handleNotFound($url)
    {
        $view = new \App\Core\View;
        $view->render('error/404');
    }

    private function dispatch($route)
    {
        list($controllerName, $method) = explode('@', $route['action']);
        $controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

        $this->handleMiddleware($route);

        if (!class_exists($controllerClass)) {
            $this->handleNotFound($route['pattern']);
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            $this->handleNotFound($route['pattern']);
            return;
        }

        $controller->$method();
    }

    private function handleMiddleware($route)
    {
        if (!array_key_exists('middleware', $route)) {
            return;
        }

        foreach ($route['middleware'] as $middleware) {
            $this->executeMiddleware($middleware);
        }
    }

    private function executeMiddleware($middleware)
    {
        if (!isset($this->middleware[$middleware])) {
            throw new \Exception("Middleware $middleware is not defined.");
        }

        $middlewareClass = $this->middleware[$middleware];

        if (!class_exists($middlewareClass)) {
            throw new \Exception("Middleware class $middlewareClass does not exist.");
        }

        $middlewareInstance = new $middlewareClass();
        $middlewareInstance->handle();
    }
}
