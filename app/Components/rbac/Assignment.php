<?php


namespace App\Components\rbac;

/**
 * Class Assignment
 *
 * @author: TOOM <1023150697@qq.com>
 */
class Assignment
{
    /**
     * @var string|int user ID (see [[\yii\web\User::id]])
     */
    public $userId;
    /**
     * @var string the role name
     */
    public $roleName;
    /**
     * @var int UNIX timestamp representing the assignment creation time
     */
    public $createdAt;
}