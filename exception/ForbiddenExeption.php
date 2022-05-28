<?php

namespace app\core\exception;

class ForbiddenExeption extends \Exception
{
    protected $message = 'Access denied';
    protected $code = 403;
}