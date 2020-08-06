<?php

declare (strict_types=1);
namespace App\Model;

use App\Components\ComponentsApplication;
use App\Components\IdentityInterface;
use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

/**
 */
class Post extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';

    /**
     * @var string
     */
    public static $tableName = 'post';

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