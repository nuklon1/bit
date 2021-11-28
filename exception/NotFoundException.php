<?php

namespace exception;

class NotFoundException extends BitException
{
    protected $message = 'Страница не найдена';
    protected $code = 404;
}