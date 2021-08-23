<?php
declare (strict_types=1);

namespace larva\wechat;

use EasyWeChat\OfficialAccount\Application;
use think\Facade;

class Wechat extends Facade
{
    /**
     * 默认为 Server.
     *
     * @return string
     */
    public static function getFacadeClass(): string
    {
        return 'wechat.official_account';
    }

    /**
     * @param mixed $name
     * @return Application
     */
    public static function officialAccount($name = ''): Application
    {
        return $name ? app('wechat.official_account.' . $name) : app('wechat.official_account');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\Work\Application
     */
    public static function work($name = ''): \EasyWeChat\Work\Application
    {
        return $name ? app('wechat.work.' . $name) : app('wechat.work');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\Payment\Application
     */
    public static function payment($name = ''): \EasyWeChat\Payment\Application
    {
        return $name ? app('wechat.payment.' . $name) : app('wechat.payment');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\MiniProgram\Application
     */
    public static function miniProgram($name = ''): \EasyWeChat\MiniProgram\Application
    {
        return $name ? app('wechat.mini_program.' . $name) : app('wechat.mini_program');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\OpenPlatform\Application
     */
    public static function openPlatform($name = ''): \EasyWeChat\OpenPlatform\Application
    {
        return $name ? app('wechat.open_platform.' . $name) : app('wechat.open_platform');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\OpenWork\Application
     */
    public static function openWork($name = ''): \EasyWeChat\OpenWork\Application
    {
        return $name ? app('wechat.open_work.' . $name) : app('wechat.open_work');
    }

    /**
     * @param mixed $name
     * @return \EasyWeChat\MicroMerchant\Application
     */
    public static function microMerchant($name = ''): \EasyWeChat\MicroMerchant\Application
    {
        return $name ? app('wechat.micro_merchant.' . $name) : app('wechat.micro_merchant');
    }
}