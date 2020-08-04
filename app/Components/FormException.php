<?php


namespace App\Components;


use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class FormException extends BadRequestHttpException
{
    public function __construct(
        $message = null,
        $code = 400,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}