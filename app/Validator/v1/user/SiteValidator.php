<?php


namespace App\Validator\v1\user;


use App\Components\FormValidator;
use function foo\func;

class SiteValidator extends FormValidator
{

    /** @var string 注册场景 */
    const SCENARIO_SIGN_UP = 'signUp';


    /**
     *
     *
     * @return array|\array[][]
     */
    public function scenariosValidator()
    {
        return [
            self::SCENARIO_SIGN_UP => [
               [['username', 'password', 'email'], 'required'],
            ]
        ];
    }
}