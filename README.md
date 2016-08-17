# laravel_wechat_open_platform
Wechat Open Platform Package For Laravel

## Install

1. Composer Install

  ```shell
  composer require "takatost/laravel_wechat_open_platform:~1.0"
  ```

> 为了保证模块正常使用，请禁用 laravel-debugbar。

## 配置

### Laravel 应用

1. 注册 `ServiceProvider`:

  ```php
  LaravelWechatOP\ServiceProvider::class,
  ```

2. 创建配置文件：

  ```shell
  php artisan vendor:publish
  ```

3. 请修改应用根目录下的 `config/wechat_op.php` 中对应的项即可；

4. （可选）添加外观到 `config/app.php` 中的 `aliases` 部分:

  ```php
  'WechatOP' => LaravelWechatOP\WechatOP::class,
  ```

## 使用

我们可以通过 `app('wechat_op')` 或外观 `WechatOP`来获取开放平台应用对象。

### 跳转公众号授权页

```
$response = WechatOP::oauth->redirect($authCallbackUrl)
// 或 $response = app('wechat_op')->oauth->redirect($authCallbackUrl)
// 获取跳转地址 $redirectUrl = $response->getTargetUrl();

return $response;
```
