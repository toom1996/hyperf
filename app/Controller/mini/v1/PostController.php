<?php


namespace App\Controller\mini\v1;


use App\Controller\BaseController;
use App\Form\mini\v1\PostForm;

class PostController extends BaseController
{

    /**
     * @\Hyperf\Di\Annotation\Inject()
     * @var \App\Validator\mini\v1\PostValidator
     */
    protected $validator;

    public function index()
    {
        $model = new PostForm();
        return $model->index();
    }

}