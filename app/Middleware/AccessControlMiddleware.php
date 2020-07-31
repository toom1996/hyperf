<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Components\ComponentsApplication;
use App\Components\ComponentsContainer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Exception\ForbiddenHttpException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Components\User;

class AccessControlMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->checkAccess($request);
        return $handler->handle($request);
    }

    /**
     *
     *
     * @param $request
     *
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function checkAccess($request)
    {
        $path = $request->getUri()->getPath();
        $params = $request->getUri()->getQuery();
        if (ComponentsApplication::$app->user->can($path, $params) !== false) {
            return true;
        }
        $this->denyAccess();

//        $user = Yii::$app->user;
//        if (AccessHelper::checkRoute('/' . $actionId, Yii::$app->getRequest()->get(), $user)) {
//            return true;
//        }
//        $this->denyAccess($user);
    }

    public function denyAccess()
    {
        if (ComponentsApplication::$app->user->getIsGuest()) {
            ComponentsApplication::$app->user->loginRequired();
        } else {
           throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }


}