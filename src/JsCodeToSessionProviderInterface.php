<?php

namespace Riftfox\Wechat\JsCodeToSession;

use Riftfox\Wechat\Application\ApplicationInterface;
use Riftfox\Wechat\Session\SessionInterface;

interface JsCodeToSessionProviderInterface
{
    const string JS_CODE_TO_SESSION_URL = 'https://api.weixin.qq.com/sns/jscode2session';
    const string GRANT_TYPE_AUTHORIZATION_CODE = 'authorization_code';

    public function jsCodeToSession(ApplicationInterface $application, string $jsCode, string $grantType = self::GRANT_TYPE_AUTHORIZATION_CODE): SessionInterface;
}