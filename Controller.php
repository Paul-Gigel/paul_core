<?php

namespace paul_core\paul_core;

use paul_core\paul_core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var \paul_core\paul_core\middlewares\BaseMiddleware[]
     */
    protected $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        //var_dump($middleware);
        //array_push($this->middlewares, $middleware);
        $this->middlewares = $middleware;
    }

    public function getMiddlewares():mixed
    {
        return $this->middlewares ?? [];
    }
}