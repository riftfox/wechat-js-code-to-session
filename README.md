# wechat-js-code-to-session

微信小程序登录凭证校验 SDK，用于获取用户 openid 和 session_key。

## 功能特性

- 封装微信小程序 auth.code2Session 接口
- 支持 PSR-7/PSR-17/PSR-18 标准
- 提供统一的会话信息数据结构

## 安装

```bash
composer require riftfox/wechat-js-code-to-session
```

## 使用方法

```php
<?php
use Riftfox\Wechat\JsCodeToSession\JsCode2SessionProvider;

$provider = new JsCode2SessionProvider(
    $client,
    $requestFactory,
    $uriFactory,
    $sessionFactory,
    $exceptionFactory
);

$application = new Application('appid', 'secret', ApplicationInterface::TYPE_MINIAPP);
$session = $provider->code2Session($application, 'js_code');

echo $session->getOpenid();      // 用户唯一标识
echo $session->getSessionKey();   // 会话密钥
echo $session->getUnionid();     // 用户在开放平台的唯一标识
```