<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class AdminUserFrontendProfile extends Model
{

    static $tableName = 'admin_user_frontend_profile';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user_frontend_profile';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

}