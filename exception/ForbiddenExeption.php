<?php

namespace paul_core\paul_core\exception;

class ForbiddenExeption extends \Exception
{
    protected $message = 'Access denied';
    protected $code = 403;
}