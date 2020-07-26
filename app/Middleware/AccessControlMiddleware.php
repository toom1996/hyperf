<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Components\User;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AccessControlMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var User
     */
    private $_user;

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
     * @param $request ServerRequestInterface
     */
    private function checkAccess($request)
    {
        $path = $request->getUri()->getPath();
        $params = $request->getUri()->getQuery();
        if ($this->_user->can($path, $params) !== false) {
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
        if ($this->_user->getIsGuest()) {
            $this->_user->loginRequired();
        } else {
            echo 'You are not allowed to perform this action.';
        }
    }


}