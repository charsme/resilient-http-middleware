<?php

namespace Resilient\Test;

use Resilient\Test\AppTest;
use PSR7Sessions\Storageless\Http\SessionMiddleware;

class SessionTest extends AppTest
{
    public function testHeader()
    {
        $app = clone $this->app;

        $app->get('/', function (ServerRequestInterface $req, ResponseInterface $resp) {
            return $resp->getBody()->write('resolved');
        })->add(
            new SessionMiddleware()
        );

        $response = $app->run(true);
        
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame('inresolvedout', (string) $response->getBody());
    }
}
