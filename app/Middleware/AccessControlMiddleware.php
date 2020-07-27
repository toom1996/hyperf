<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Di\Annotation\Inject;
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

    /**
     * @Inject()
     * @var User
     */
    private $user;

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
        if ($this->user->can($path, $params) !== false) {
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
        if ($this->user->getIsGuest()) {
            $this->user->loginRequired();
        } else {
            echo 'You are not allowed to perform this action.';
        }
    }


}