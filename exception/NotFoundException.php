<?php

namespace paul_core\paul_core\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Not Found';
    protected $code = 404;
}