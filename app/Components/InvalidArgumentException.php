<?php


namespace App\Components;

use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class InvalidArgumentException extends BadRequestHttpException
{

    public function __construct(
        $message = 'Bad Request',
        $code = 400,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}