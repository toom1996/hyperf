<?php


namespace App\Components\auth;


use App\Components\UnauthorizedHttpException;
use App\Components\User;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class QueryParamsAuth extends AuthInterface
{

    /**
     * @var string
     */
    private $tokenParam = 'token';
    private $tokenSecret = 'token-secret';

    /**
     *
     *
     * @param $user
     * @param  null  $secretKey
     *
     * @return mixed|null
     */
    public function authenticate($user, $secretKey = null)
    {
        $accessToken = $this->request->input($this->tokenParam, null);
        $tokenSecret = $this->request->input($this->tokenSecret, null);

        if (is_string($accessToken) && $this->invalidateToken($accessToken, $tokenSecret, $secretKey)) {
            /** @var User $user */
            $identity = $user->loginByAccessToken($accessToken);
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
            //TODO 抛出异常
        }

        return null;
    }

    private function invalidateToken($token, $tokenSecret, $secretKey)
    {
        if ($secretKey === null) {
            return false;
        }
        var_dump(substr(md5($token . $secretKey), -5));
        if(substr(md5($token . $secretKey), -5) !== $tokenSecret) {
            return false;
        }

        return true;
    }

}