<?php


namespace App\Components;


use Hyperf\Server\Exception\ServerException;
use Throwable;

/**
 * Class UnauthorizedHttpException
 *
 * @author: TOOM <1023150697@qq.com>
 */
class UnauthorizedHttpException extends ServerException
{
    public function __construct(
        $message = "Your request was made with invalid credentials.",
        $code = 401,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}