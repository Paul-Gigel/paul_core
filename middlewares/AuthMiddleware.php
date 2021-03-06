<?php

namespace paul_core\paul_core\middlewares;

use paul_core\paul_core\Application;
use paul_core\paul_core\exception\ForbiddenExeption;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = array(); //profile
    public function __construct(array $actions = [])
    {
        //array_push($this->actions, $actions);
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))  {
                throw new ForbiddenExeption();
            }
        }
    }
}