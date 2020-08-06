<?php


namespace App\Controller\mini\v1;


use App\Components\ComponentsApplication;
use App\Controller\BaseController;
use App\Form\mini\v1\SiteForm;

class SiteController extends BaseController
{

    /**
     * @\Hyperf\Di\Annotation\Inject()
     * @var \App\Validator\mini\v1\SiteValidator
     */
    protected $validator;

    /**
     * 小程序登陆接口
     * /mini/login
     * @return array
     */
    public function login()
    {
        $this->validator->setScenario($this->validator::SCENARIO_GET_SESSION);
        $this->validator->setAttributes($this->request->post());
        if (!$this->validator->validate()) {
            return [
                'code' => 400,
                'message' => $this->validator->getFirstError()
            ];
        }

        $model = new SiteForm($this->validator->attributes());
        $model->login();
        return [
            'code' => 200,
            'message' => '登陆成功'
        ];
    }

}