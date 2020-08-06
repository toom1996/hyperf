<?php


namespace App\Components\wechat;

use App\Components\BaseComponents;
use EasyWeChat\Factory;
use EasyWeChat\MiniProgram\Application;

/**
 * Class Wechat
 *
 * @author: TOOM <1023150697@qq.com>
 */
class Wechat extends BaseComponents
{

    /**
     * 公众号实例
     * @var
     */
    private static $easyWechatApp;

    /**
     * 小程序实例
     * @var
     */
    private static $miniApp;




    /**
     * easyWechay Application
     * @return \EasyWeChat\OfficialAccount\Application
     */
    public function getApp()
    {
        if (!self::$easyWechatApp instanceof \EasyWeChat\OfficialAccount\Application) {
            $config = config('components.wechat');
            self::$easyWechatApp = Factory::officialAccount($config);
            //缓存模块替换
            self::$easyWechatApp->rebind('cache', new WechatCache());
        }

        return self::$easyWechatApp;
    }

    /**
     *
     *
     * @return \EasyWeChat\MiniProgram\Application
     */
    public function getMiniApp()
    {
        if (!self::$miniApp instanceof \EasyWeChat\MiniProgram\Application) {
            $config = config('components.wechat.miniApp');
            self::$miniApp = Factory::miniProgram($config);
            //缓存模块替换
            self::$miniApp->rebind('cache', new WechatCache());
        }

        return self::$miniApp;
    }

}