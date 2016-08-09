<?php
/*
 * This file is part of the takatost/wechat_open_platform.
 *
 * (c) takatost <takatost@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LaravelWechatOP;


use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use WechatOP\Foundation\WechatOpenApplication;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * 延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/config.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('wechat_op.php'),
            ]);
        }
        $this->mergeConfigFrom($source, 'wechat_op');
    }

    /**
     * Register
     */
    public function register()
    {
        $this->app->singleton(['WechatOP\\Foundation\\WechatOpenApplication' => 'wechat_op'], function ($app) {
            $config = config('wechat_op');
            if ($config['cache']['driver'] === 'laravel') {
                $config['cache'] = new CacheBridge();
            }

            return new WechatOpenApplication($config);
        });
    }

    /**
     * 提供的服务
     *
     * @return array
     */
    public function provides()
    {
        return ['wechat_op', 'WechatOP\\Foundation\\WechatOpenApplication'];
    }
}