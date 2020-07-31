<?php


namespace App\Controller\v1\user;


use App\Components\ComponentsApplication;
use App\Controller\BaseController;
use App\Form\SiteForm;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class SiteController
 *
 * @author: TOOM <1023150697@qq.com>
 * @AutoController()
 */

class SiteController extends BaseController
{

    /**
     * @Inject()
     * @var \App\Validator\v1\user\SiteValidator
     */
    private $validator;

    public function login()
    {
        return 1;
    }


    public function signUp()
    {
        $this->validator->setScenario($this->validator::SCENARIO_SIGN_UP);
        $this->validator->setAttributes($this->request->post());
        if (!$this->validator->validate()) {
           return [
               'code' => 400,
               'message' => $this->validator->getFirstError()
           ];
        }

        $model = new SiteForm($this->validator->getAttributes());
        $model->sign();

    }
}