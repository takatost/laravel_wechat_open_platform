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

use Illuminate\Support\Facades\Facade as LaravelFacade;

class WechatOP extends LaravelFacade
{
    /**
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wechat_op';
    }

    /**
     * 获取微信开放平台 SDK 服务
     *
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        $app = static::getFacadeRoot();
        if (method_exists($app, $name)) {
            return call_user_func_array([$app, $name], $args);
        }
        return $app->$name;
    }
}