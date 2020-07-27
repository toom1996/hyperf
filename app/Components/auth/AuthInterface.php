<?php


namespace App\Components\auth;


use App\Components\BaseComponents;

abstract class AuthInterface extends BaseComponents
{

    /**
     * secretKey
     * @var
     */
    protected $s;

    /**
     *
     *
     * @param $user
     * @param $secretKey
     *
     * @return mixed
     */
    abstract public function authenticate($user, $secretKey);

}