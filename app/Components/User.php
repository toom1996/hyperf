<?php


namespace App\Components;



use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
/**
 * Class User
 *
 * @author: TOOM <1023150697@qq.com>
 *
 */
class User
{

    /**
     * @Inject()
     * @var AuthManager
     */
    private $authManager;

    /**
     * @Inject()
     * @var UserIdentity
     */
    private $user;

    public function __construct()
    {
        Context::set('_identity', false);
        Context::set('_access', []);

        $identityCookie = ['name' => '_identity', 'httpOnly' => true];
        $loginUrl = ['site/login'];
        $enableSession = true;
        $enableAutoLogin = false;
        $authTimeout;
        $accessChecker;
        $absoluteAuthTimeout;
        $autoRenewCookie = true;
        $idParam = '__id';
        $authTimeoutParam = '__expire';
        $absoluteAuthTimeoutParam = '__absoluteExpire';
        $returnUrlParam = '__returnUrl';
        $acceptableRedirectTypes = ['text/html', 'application/xhtml+xml'];
    }


    public function getIdentity($autoRenew = true)
    {
        if ($this->_identity === false) {
            if ($this->enableSession && $autoRenew) {
                try {
                    $this->_identity = null;
                    $this->renewAuthStatus();
                } catch (\Exception $e) {
                    $this->_identity = false;
                    throw $e;
                } catch (\Throwable $e) {
                    $this->_identity = false;
                    throw $e;
                }
            } else {
                return null;
            }
        }

        return $this->_identity;
    }

    /**
     *
     *
     * @param         $permissionName //路由地址
     * @param  array  $params
     * @param  bool   $allowCaching
     *
     * @return bool|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && empty($params) && isset($this->_getProperty('_access')[$permissionName])) {
            return $this->_getProperty('_access')[$permissionName];
        }

        $access = $this->authManager->checkAccess($this->getId(), $permissionName, $params);
        if ($allowCaching && empty($params)) {
            $this->_getProperty('_access')[$permissionName] = $access;
        }

        return $access;
    }

    /**
     *
     *
     * @return |null
     */
    public function getId()
    {
        $identity = $this->user->getUser();

        return $identity !== null ? $this->user->getId() : null;
    }

    /**
     *
     *
     * @return bool
     */
    public function getIsGuest()
    {
        return $this->user->isGuest() === null;
    }


    public function loginRequired()
    {
        //TODO
        echo '对没登录对用户做跳转处理或者干啥的...';
    }
    /**
     *
     *
     * @param $name
     *
     * @return mixed|null
     */
    private function _getProperty($name)
    {
        return Context::get($name);
    }
}