<?php

namespace Resilient\MiddleWare;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Dflydev\FigCookies\SetCookie;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class SessionAuthToken implements MiddlewareInterface
{
    const DEFAULT_NAME = 'grizzly';
    const DEFAULT_TIMEOUT = 500;

    private $appkey;
    private $signerKey;
    private $bearer;

    private $tokenValidation;

    public function __construct(
        string $signerKey,
        string $appkey,
        $bearer = self::DEFAULT_NAME
    ) {
        $this->appkey = $appkey;
        $this->signerKey = $signerKey;
        $this->withBearer($bearer);
    }
    
    protected function resolveBearer($bearer, int $timeout = self::DEFAULT_TIMEOUT)
    {
        if ($bearer instanceof SetCookie) {
            return $bearer;
        }

        if (is_string($bearer)) {
            return $this->createBearer($bearer, $timeout);
        }

        throw new \Exception("bearer must be string or instance of Dflydev\FigCookies\SetCookie");
    }

    public function withBearer($bearer, int $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->bearer = $this->resolveBearer($bearer, $timeout);

        return $this;
    }

    protected function createBearer(string $name, int $timeOut, $default = null): SetCookie
    {
        return SetCookie::create($name, $default)
            ->withExpires($timeOut)
            ->withHttpOnly(true)
            ->withSecure(true)
            ->withPath('/');
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        
    }

    protected function parseToken(ServerRequestInterface $request)
    {
        $cookies = $request->getCookieParams();
        $bearerName = $this->bearer->getName();

        if (!isset($cookies[$bearerName])) {
            return null;
        }

        try {
            $token = (new Parser())->parse($cookies[$bearerName]);
        } catch (\InvalidArgumentException $invalidToken) {
            return null;
        }

        if (! $token->validate(new ValidationData())) {
            return null;
        }

        return $token;
    }
}
