<?php

namespace app\core;

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\exception\ForbiddenExeption;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\BaseMiddleware;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [
       /*
        * 'get' => [
        *     '/' => $callback,
        *     '/contacts' => $callback
        * ],
        * 'post' => [
        *     ...
        * ]
        */
    ];

    /**
     * @param Request $request
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false)    {
            throw new NotFoundException();
        }
        if (is_string($callback))   {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback))    {
            /**
             * @var Controller $controller
             */
            Application::$app->controller = new $callback[0](); // Authcontroller::class oder Sitecontroller::class
            Application::$app->controller->action = $callback[1];   // 
            $callback[0] = Application::$app->controller;
            foreach (Application::$app->controller->getMiddlewares() as  $middleware)  {
                //var_dump(Application::$app->controller->getMiddlewares());
                Application::$app->controller->getMiddlewares()->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
}