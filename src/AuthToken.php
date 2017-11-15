<?php

namespace Resilient\MiddleWare;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthToken implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
    }
}
