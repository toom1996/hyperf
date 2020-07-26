<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Cache\Annotation\Cacheable;
/**
 */
class AdminUserFrontend extends Model
{

    //被禁用的账户
    const STATUS_DELETED = 0;
    //等待验证的用户
    const STATUS_INACTIVE = 9;
    //已验证用户
    const STATUS_ACTIVE = 10;


    /**
     * @\Hyperf\Di\Annotation\Inject()
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user_frontend';
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

    /**
     *
     *
     * @param $token
     *
     * @return bool
     */
    public function getIdentityByAccessToken($token)
    {
        if ($query = $this->cache->get($token)) {
            return $query;
        }

        $query = Db::table($this->table . ' as user')
            ->select('user.*', 'profile.user_token')
            ->leftJoin(AdminUserFrontendProfile::$tableName . ' as profile', 'user.id', '=', 'profile.uid')
            ->where('profile.user_token', $token)
            ->first() ?: false ;
        if ($query !== false) {
            $this->cache->set($token, $query);
        }
        return $query;

    }

}