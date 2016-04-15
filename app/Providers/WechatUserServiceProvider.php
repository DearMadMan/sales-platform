<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WechatUserService;
use App\WechatConfig;
use App\User;

class WechatUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 注入公众号配置信息
        $manager_config = new WechatConfig();
        $manager_config = $manager_config->where("manager_id", 1)->first();
        if (!$manager_config) {
            return false;
        }
        $configs = $manager_config->getConfigs();
        $userService = $this->app->make('App\Services\WechatUserService');
        $userService->init($configs);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WechatUserService::class, function ($app) {
            return new WechatUserService(new User());
        });
    }
}
