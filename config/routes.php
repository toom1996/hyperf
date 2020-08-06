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
use Hyperf\HttpServer\Router\Router;

Router::addGroup('/v1/user/', function () {
    Router::post('site/sign-up','App\Controller\v1\user\SiteController@signUp');
}, ['middleware' => [\App\Middleware\AccessControlMiddleware::class]]);


Router::addGroup('/mini', function () {
    Router::get('/index','App\Controller\mini\v1\PostController@index');
    Router::post('/login','App\Controller\mini\v1\SiteController@login');
});


//TEST
Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index', ['middleware' => [\App\Middleware\AccessControlMiddleware::class]]);
