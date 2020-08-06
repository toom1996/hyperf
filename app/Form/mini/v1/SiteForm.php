<?php


namespace App\Form\mini\v1;


use _HumbugBox5f943a942674\Nette\Neon\Exception;
use App\Components\BaseFormModel;
use App\Components\ComponentsApplication;
use App\Components\FormException;
use App\Model\UserModel;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\DbConnection\Db;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;

class SiteForm extends BaseFormModel
{

    /**
     * 小程序code
     * @var
     */
    public $code;


    public function login()
    {
        $app = ComponentsApplication::$app;

        Db::beginTransaction();

        $response = $app->wechat->getMiniApp()->auth->session($this->code);
        if (!isset($response['openid'])) {
            Db::rollBack();
            throw new FormException('登陆失败');
        }

        if (!UserModel::findIdentityByMiniProgramOpenId($response['openid'])) {
            $model = Db::table(UserModel::$tableName);
            $arr = [
                'mini_openid' => $response['openid']
            ];
            if (!$model->insert($arr)) {
                Db::rollBack();
                throw new FormException('登陆失败');
            }
        }

        Db::commit();
    }
}