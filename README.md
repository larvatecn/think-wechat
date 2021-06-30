# think-wechat

微信 SDK For ThinkPHP 6.0 基于[overtrue/wechat](https://github.com/overtrue/wechat)

## 框架要求

ThinkPHP6.0(中间件要求支持 ThinkPH6.0+)

## 安装

```
composer require larva/think-wechat -vv
```

## 配置

1. 修改配置文件
   修改项目根目录下 config/wechat.php 中对应的参数

2. 每个模块基本都支持多账号，默认为 default。

## 使用

### 接受普通消息

新建一个 Controller，我这边用的是 Wechat

```php
<?php

namespace app\controller;

use think\Controller;

class Wechat extends Controller
{

    public function index()
    {
        //    先初始化微信
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return 'hello,world';
        });
        $app->server->serve()->send();
    }
}
```

#### 获得 SDK 实例 使用 Facade

```php
use larva\wechat\Wechat;

$officialAccount = Wechat::officialAccount();  // 公众号
$work = Wechat::work(); // 企业微信
$payment = Wechat::payment(); // 微信支付
$openPlatform = Wechat::openPlatform(); // 开放平台
$miniProgram = Wechat::miniProgram(); // 小程序
$openWork = Wechat::openWork(); // 企业微信第三方服务商
$microMerchant = Wechat::microMerchant(); // 小微商户
```

以上均支持传入自定义账号:例如

```php
$officialAccount = Wechat::officialAccount('test'); // 公众号
```

更多 SDK 的具体使用请参考：https://easywechat.com

#### 中间件参数说明

由于ThinkPHP中间件只支持一个参数，所以以:做分割

支持传入account账号别名以及scope类型

若不传入account，会使用default账号

若不传入scope，会使用配置文件中的oauth.scope

支持一下两种方式

default:snsapi_base
snsapi_base

## 参考项目

-   [overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat)
-   [naixiaoxin/think-wechat](https://github.com/naixiaoxin/think-wechat)

