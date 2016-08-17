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

授权流程详见：[开放平台文档](https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1453779503&token=&lang=zh_CN)
我们可以通过 `app('wechat_op')` 或外观 `WechatOP`来获取开放平台应用对象。

### 跳转公众号授权页

```
$callbackUrl = 'http://for.bar/callback'; // 授权回调地址
$response = WechatOP::oauth->redirect($callbackUrl);  // 或 $response = app('wechat_op')->oauth->redirect($authCallbackUrl);
// 获取跳转地址 $redirectUrl = $response->getTargetUrl();

return $response;
```

### 授权回调信息获取

授权后需要记录公众号的 `appid` 和 `authorizer_refresh_token` 以代公众号实现业务。

```
$authInfo = WechatOP::oauth->user();
/** 
{
  "id": "appid",
  "name": "公众号名称",
  "nickname": "公众号名称",
  "avatar": "公众号头像",
  "email": null,
  "authorizer_info": {
    "nick_name": "公众号名称",
    "head_img": "公众号头像",
    "service_type_info": {
      "id": 2
    },
    "verify_type_info": {
      "id": 0
    },
    "user_name": "公众号ID",
    "business_info": {
      "open_store": 1,
      "open_scan": 1,
      "open_pay": 1,
      "open_card": 1,
      "open_shake": 1
    },
    "alias": "公众号别名"
  },
  "qrcode_url": "公众号二维码图片地址",
  "authorization_info": {
    "authorizer_appid": "appid",
    "authorizer_access_token": "authorizer_access_token",
    "expires_in": 7200,
    "authorizer_refresh_token": "authorizer_refresh_token",
    "func_info": [
      {
        "funcscope_category": {
          "id": 1
        }
      },
      {
        "funcscope_category": {
          "id": 2
        }
      },
      {
        "funcscope_category": {
          "id": 3
        }
      }
    ]
  }
}
**/
```

### 接收事件

```
$server = WechatOP::server;
$server->setMessageHandler(function($message) {
        switch ($message->get('InfoType')) {
            case "component_verify_ticket":
                // 保存开放平台 ticket
                env('wechat_op')->saveTicket($message->get('ComponentVerifyTicket'));
                break;
            case "unauthorized":                
                // 公众号取消授权记录
                break;
            default:
                break;
        }
    });
    
return $server->serve();
```

### 代公众号实现业务

每个平台下的公众号都需要单独传入配置

```
$options = [
        'app_id'    => '公众号 app_id',
        'secret'    => '公众号 secret',   // 仅适用于 单独配置公众号
        'token'     => '公众号 token',   // 仅适用于 单独配置公众号
        'aes_key'   => '公众号 aes_key',   // 仅适用于 单独配置公众号
        'auth_type' => 'COMPONENT', // COMPONENT 开放平台授权公众号，MANUAL 单独配置公众号
        'component_refresh_token' => 'component_refresh_token',   // 授权回调时获取的 authorizer_refresh_token，仅适用于 开放品台授权公众号
        'oauth'     => [
            'scopes' => ['snsapi_base'] // 公众号授权用户方式 snsapi_base, snsapi_userinfo
        ],
    ];

$wechatApp = WechatOP::app($options);
```

`$wechatApp` 为 `EasyWechat\Foundation\Application` 对象，使用方式见 [EasyWeChat 文档](https://easywechat.org/zh-cn/docs/)
