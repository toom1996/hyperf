<?php


namespace App\Form\mini\v1;


use App\Components\BaseFormModel;
use App\Model\Post;
use Hyperf\DbConnection\Db;

class PostForm extends BaseFormModel
{

    public function index()
    {
        $model = Db::table(Post::$tableName);
        $query = $model->select([
            'content', 'image', 'video', 'created_at', 'created_by', 'likes',
            'comments', 'share'
        ])->orderBy('created_at', 'DESC')->limit(10)->get();

        return [
            'code' => 200,
            'data' => $query
        ];
    }

}