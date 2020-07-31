<?php


namespace App\Components;


use Hyperf\HttpMessage\Exception\ForbiddenHttpException as BaseException;

class ForbiddenHttpException extends BaseException
{
    public function __construct(
        $message = 'You are not allowed to perform this action.',
        $code = 403,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}