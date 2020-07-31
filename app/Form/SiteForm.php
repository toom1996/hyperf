<?php


namespace App\Form;


use App\Components\BaseFormModel;
use App\Components\ComponentsApplication;
use App\Model\AdminUserFrontend;
use Hyperf\DbConnection\Db;

class SiteForm extends BaseFormModel
{
    public $username;

    public $password;

    public $email;


    public function sign()
    {

            $insertParam = [
                'username' => $this->username,
                'email' => $this->email,
                'password_hash' => ComponentsApplication::$app->security->generatePasswordHash($this->password),
                'auth_key' => ComponentsApplication::$app->security->generateRandomString(),
                'created_at' => ComponentsApplication::$app->security->generateRandomString(),
                'updated_at' => ComponentsApplication::$app->security->generateRandomString(),
            ];
            $a = Db::table('admin_user_frontend')->insert($insertParam);



//        var_dump(ComponentsApplication::$app->user->identityClass::generatePasswordHash(123123));
    }
}