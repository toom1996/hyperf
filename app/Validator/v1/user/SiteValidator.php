<?php


namespace App\Validator\v1\user;


use App\Components\FormValidator;
use App\Model\UserModel;
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
               [['username', 'email'], 'exist', 'targetClass' => UserModel::class, 'message' => '{attribute} {value} 已经被占用了.']
            ]
        ];
    }
}