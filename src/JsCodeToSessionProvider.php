<?php

namespace Riftfox\Wechat\JsCodeToSession;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Riftfox\Wechat\Application\ApplicationInterface;
use Riftfox\Wechat\Exception\ExceptionFactoryInterface;
use Riftfox\Wechat\Session\SessionFactoryInterface;
use Riftfox\Wechat\Session\SessionInterface;

class JsCodeToSessionProvider implements JsCodeToSessionProviderInterface
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private UriFactoryInterface $uriFactory;
    private ExceptionFactoryInterface $exceptionFactory;
    private SessionFactoryInterface $sessionFactory;

    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory, UriFactoryInterface $uriFactory,SessionFactoryInterface $sessionFactory, ExceptionFactoryInterface $exceptionFactory )
    {
        $this->httpClient = $client;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->exceptionFactory = $exceptionFactory;
        $this->sessionFactory = $sessionFactory;
    }
    public function jsCodeToSession(ApplicationInterface $application, string $jsCode, string $grantType = self::GRANT_TYPE_AUTHORIZATION_CODE): SessionInterface
    {
        // TODO: Implement jsCodeToSession() method.
        $request = $this->getrequest($application, $jsCode, $grantType);
        $response = $this->httpClient->sendRequest($request);
        $data = json_decode($response->getBody()->getContents(), true);
        if($data['errcode'] !== 0){
            throw $this->exceptionFactory->createException($data['errmsg'], $data['errcode']);
        }
        return $this->sessionFactory->createSessionFromArray($data);
    }

    public function getRequest(ApplicationInterface $application, string $jsCode, string $grantType = self::GRANT_TYPE_AUTHORIZATION_CODE): RequestInterface
    {
        $uri = $this->uriFactory->createUri(self::JS_CODE_TO_SESSION_URL);
        $uri = $uri->withQuery(http_build_query([
            'appid' => $application->getAppId(),
            'secret' => $application->getAppSecret(),
            'js_code' => $jsCode,
            'grant_type' => $grantType,
        ]));
        return $this->requestFactory->createRequest('GET', $uri);
    }
}