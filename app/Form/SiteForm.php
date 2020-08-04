<?php


namespace App\Form;


use App\Components\BaseFormModel;
use App\Components\ComponentsApplication;
use App\Components\FormException;
use App\Model\AdminUserFrontend;
use Hyperf\DbConnection\Db;

class SiteForm extends BaseFormModel
{
    public $username;

    public $password;

    public $email;


    public function sign()
    {
        throw new FormException('注册失败');
        $time = time();

        $insertParam = [
            'username' => $this->username,
            'email' => $this->email,
            'password_hash' => ComponentsApplication::$app->security->generatePasswordHash($this->password),
            'auth_key' => ComponentsApplication::$app->security->generateRandomString(),
            'created_at' => $time,
            'updated_at' => $time,
        ];
//        $model = Db::table('admin_user_frontend')->insert($insertParam);


        return true;
    }
}