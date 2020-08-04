<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'handler' => [
        'http' => [
            \App\Exception\Handler\AuthExceptionHandler::class, //token handler
            \App\Exception\Handler\ForbiddenExceptionHandler::class, //角色路由 handler
            \App\Exception\Handler\FormExceptionHandler::class, //modelForm handler


            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            App\Exception\Handler\AppExceptionHandler::class
        ],
    ],
];
