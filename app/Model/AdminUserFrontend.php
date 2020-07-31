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
class AdminUserFrontend extends Model implements IdentityInterface
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



    public static function findIdentity($id)
    {

    }


    public static function findIdentityByAccessToken($token)
    {
        $cache = ApplicationContext::getContainer()->get(CacheInterface::class);
        if ($query = $cache->get($token)) {
            echo '__CACHE__' . PHP_EOL;
            return $query;
        }

        $query = Db::table('admin_user_frontend' . ' as user')
            ->select('user.*', 'profile.user_token')
            ->leftJoin(AdminUserFrontendProfile::$tableName . ' as profile', 'user.id', '=', 'profile.uid')
            ->where('profile.user_token', $token)
            ->first() ?: false ;
        echo '__DB__';
        if ($query !== false) {
            $cache->set($token, $query);
        }
        return $query;
    }

    public function getId()
    {
        echo 666666666666666666;
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {

    }

    /**
     * 生成密码哈希
     * 生成的有点慢....
     *
     * @param $password
     *
     * @return string
     * @throws \Exception
     */
    public static function generatePasswordHash($password)
    {
        return ComponentsApplication::$app->security->generatePasswordHash($password);
    }
}