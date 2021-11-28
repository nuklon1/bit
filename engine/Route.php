<?php

namespace engine;

use exception\NotFoundException;

class Route
{
    public static array $route = [];
    public static array $routes = [];

    public static function get(string $url, $data)
    {
        self::$routes['get'][$url] = $data;
    }

    public static function post(string $url, $data)
    {
        self::$routes['post'][$url] = $data;
    }

    public static function run()
    {
        $path = self::getPath();
        try {
            self::matchRoute($path);
            $controller = '\app\controllers\\' . self::$route['controller'];
            $action = self::$route['action'];
            self::checkRoute($controller, $action);
            (new $controller())->$action();
        }
        catch (NotFoundException $e) {
            http_response_code($e->getCode());
            echo $e->getMessage();
            die;
        }
    }

    /**
     * @throws NotFoundException
     */
    public static function matchRoute($url)
    {
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $routes = self::$routes[$requestMethod] ?? [];

        if (!array_key_exists($url, $routes)) {
            throw new NotFoundException();
        }

        $route = $routes[$url];
        list($controller, $action) = explode('@', $route);
        $action ??= 'index';

        self::$route = [
            'controller' => $controller,
            'action' => $action,
        ];
    }
    
    public static function getPath(): string
    {
        $path = explode('?', $_SERVER['REQUEST_URI']);
        return $path[0];
    }

    /**
     * @throws NotFoundException
     */
    public static function checkRoute($controller, $action)
    {
        $route = self::$route;
        if (empty($route)) {
            throw new NotFoundException();
        }

        if (!class_exists($controller)) {
            throw new NotFoundException();
        }

        if (!method_exists($controller, $action)) {
            throw new NotFoundException();
        }
    }
}