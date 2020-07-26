<?php

declare(strict_types=1);

namespace App\Middleware;


use App\Model\AdminUserFrontend;
use Hyperf\HttpMessage\Server\RequestParserInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;


/**
 * Class IdentityComponent
 *
 * @author: TOOM <1023150697@qq.com>
 *
 * @property $user
 * @property $identity
 */
class UserMiddleware
{
    /**
     * 用来存储用户信息的数组
     * @var
     */
    private $userArray;

    public function __construct()
    {
        Context::set('user', null);
    }

    /**
     * userModel类
     * @\Hyperf\Di\Annotation\Inject()
     * @var AdminUserFrontend
     */
    private $_userModel;

    /**
     * @\Hyperf\Di\Annotation\Inject()
     * @var RequestInterface
     */
    private $request;

    private function findIdentity()
    {
        $token = $this->request->getQueryParams()['token'];
        echo 'token' . $token;
        return $this->_userModel->getIdentityByAccessToken($token);
    }

    /**
     * 获取user对象
     *
     * @return mixed|null
     */
     public function getUser()
     {
        return $this->_getUser();
     }

    /**
     *
     *
     * @return mixed
     */
     public function getId()
     {
         return $this->_getUser()->id;
     }


    /**
     *
     *
     * @return mixed|null
     */
     private function _getUser()
     {
        if (Context::get('user') === null) {
            Context::set('user', $this->findIdentity());
        }
        return Context::get('user');
    }

}