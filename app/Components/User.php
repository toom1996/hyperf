<?php


namespace App\Components;



use App\Components\auth\AuthInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;


/**
 * Class User
 *
 * @author: TOOM <1023150697@qq.com>
 *
 */
class User extends BaseComponents
{

    /**
     * @Inject()
     * @var AuthManager
     */
    private $authManager;

    private $tokenSecret;


    public function __construct()
    {
        $this->tokenSecret = config('user.secretKey');
    }

    /**
     *
     *
     * @param  bool  $autoRenew
     *
     * @return mixed|null
     */
    public function getIdentity($autoRenew = true)
    {
        if ($this->_getProperty('_identity') === null && $this->_getProperty('_identityIsGet') !== true) {
            $identity = null;
            /** @var  $authClass */
            $authClass = config('user.authClass');
            $authObj = new $authClass;
            if ($authObj instanceof AuthInterface) {
                $identity = $authObj->authenticate($this, $this->tokenSecret);
                var_dump($identity);
            } else {
                //TODO EXCEPTION
            }
            $this->_setProperty('_identity', $identity);
//            if ($this->enableSession && $autoRenew) {
//                try {
//                    $this->_identity = null;
//                    $this->renewAuthStatus();
//                } catch (\Exception $e) {
//                    $this->_identity = false;
//                    throw $e;
//                } catch (\Throwable $e) {
//                    $this->_identity = false;
//                    throw $e;
//                }
//            } else {
//                return null;
//            }
            $this->_setProperty('_identityIsGet', true);
        }

        return $this->_getProperty('_identity');
    }

    /**
     *
     *
     * @param $token
     *
     * @return |null
     */
    public function loginByAccessToken($token)
    {
        /** @var \App\Components\IdentityInterface $class */
        $class = config('user.identityClass');
        $identity = $class::findIdentityByAccessToken($token);
        if ($identity && $this->login($identity)) {
            return $identity;
        }
        return null;
    }

    /**
     *
     *
     * @param $identity \App\Components\IdentityInterface
     *
     * @return bool
     */
    public function login($identity)
    {
        //SESSION 登陆
//        $this->switchIdentity($identity, $duration);

//        $id = $identity->getId();
//        $ip = $this->request->cl
//        if ($this->enableSession) {
//            $log = "User '$id' logged in from $ip with duration $duration.";
//        } else {
//            $log = "User '$id' logged in from $ip. Session not enabled.";
//        }

//        $this->regenerateCsrfToken();
        return !$this->getIsGuest();
    }

    public function switchIdentity($identity, $duration = 0)
    {

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
     * @throws \Throwable
     */
    public function getId()
    {
//        $identity = $this->user->getUser();
        /** @var \App\Components\IdentityInterface $identity */
        $identity = $this->getIdentity();

        return $identity !== null ? $identity->id : null;
    }

    /**
     *
     *
     * @return bool
     * @throws \Throwable
     */
    public function getIsGuest()
    {
        return $this->getIdentity() === null;
    }


    public function loginRequired()
    {
        throw new UnauthorizedHttpException('aaasdfsdf');
    }

}