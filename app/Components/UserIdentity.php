<?php

declare(strict_types=1);

namespace App\Components;


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
class UserIdentity
{
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

        if (Context::get('isGuest') === true) {
            return null;
        }
        $info = $this->_userModel->getIdentityByAccessToken($token);

        if ($info === false) {
            Context::set('isGuest', true);
            return null;
        }

        return $info;
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
     public function isGuest()
     {
         return Context::get('isGuest');
     }


    /**
     *
     *
     * @return mixed|null
     */
     private function _getUser()
     {
         Context::set('user', false);

         if (Context::get('isGuest') === null) {
             Context::set('isGuest', false);
         }

         if (Context::get('user') === false) {
            Context::set('user', $this->findIdentity());
         }

         return Context::get('user');
    }

}