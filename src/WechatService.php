<?php
declare (strict_types=1);

namespace Larva\Wechat;

use think\Cache;
use think\Service;

class WechatService extends Service
{
    /**
     * @var array|string[]
     */
    protected array $apps = [
        'official_account' => \EasyWeChat\OfficialAccount\Application::class,
        'work' => \EasyWeChat\Work\Application::class,
        'mini_program' => \EasyWeChat\MiniProgram\Application::class,
        'payment' => \EasyWeChat\Payment\Application::class,
        'open_platform' => \EasyWeChat\OpenPlatform\Application::class,
        'open_work' => \EasyWeChat\OpenWork\Application::class,
        'micro_merchant' => \EasyWeChat\MicroMerchant\Application::class,
    ];

    /**
     * 注册服务
     *
     * @return void
     */
    public function register()
    {
        $default = config('wechat.default') ? config('wechat.default') : [];
        foreach ($this->apps as $name => $app) {
            if (! config('wechat.' . $name)) {
                continue;
            }
            $configs = config('wechat.' . $name);
            foreach ($configs as $config_name => $module_default) {
                $this->app->bind('wechat.' . $name . '.' . $config_name, function ($config = []) use ($app, $module_default, $default) {
                    //合并配置文件
                    $account_config = array_merge($module_default, $default, $config);
                    $account_app = app($app, ['config' => $account_config]);
                    if (config('wechat.default.use_tp_cache')) {
                        $account_app['cache'] = app(Cache::class);
                    }
                    return $account_app;
                });
            }
            if (isset($configs['default'])) {
                $this->app->bind('wechat.' . $name, 'wechat.' . $name . '.default');
            }
        }

        $this->app->bind('wechat.facade', Wechat::class);
    }

    /**
     * 执行服务
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}