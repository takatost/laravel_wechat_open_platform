<?php

return [
    /*
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,
    /*
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,
    /*
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => env('WECHAT_OP_APPID', 'your-app-id'),         // AppID
    'secret'  => env('WECHAT_OP_SECRET', 'your-app-secret'),     // AppSecret
    'token'   => env('WECHAT_OP_TOKEN', 'your-token'),          // Token
    'aes_key' => env('WECHAT_OP_AES_KEY', ''),                    // EncodingAESKey
    'cache'   => [
        'driver' => 'filesystem',    // redis, filesystem
        'dir' => storage_path('tmp')
    ],
    /*
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => env('WECHAT_OP_LOG_LEVEL', 'debug'),
        'file'  => env('WECHAT_OP_LOG_FILE', storage_path('logs/wechat_op.log')),
    ]
];