<?php


namespace App\Components;


use Hyperf\HttpMessage\Exception\UnauthorizedHttpException as BaseException;
use Throwable;

/**
 * Class UnauthorizedHttpException
 *
 * @author: TOOM <1023150697@qq.com>
 */
class UnauthorizedHttpException extends BaseException
{
    public function __construct(
        $message = "Your request was made with invalid credentials.",
        $code = 401,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}