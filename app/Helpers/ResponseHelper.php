<?php


namespace App\Helpers;


class ResponseHelper
{

    public static function success($message = '请求成功', $code = 200)
    {
        return [
            'message' => $message,
            'code' => $code,
        ];
    }

}