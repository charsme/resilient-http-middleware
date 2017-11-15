<?php

namespace Resilient\Test;

use PHPUnit\Framework\TestCase;
use Slim\App;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AppTest extends TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new App([
            'environment' => function (ContainerInterface $container) {
                return Environment::mock();
            }
        ]);
    }

    public function testApp():void
    {
        $app = clone $this->app;

        $app->get('/', function (ServerRequestInterface $req, ResponseInterface $resp) {
            return $resp->getBody()->write('resolved');
        });

        $response = $app->run(true);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame('resolved', (string) $response->getBody());

        return;
    }

    public function testAddingMiddleWare():void
    {
        $app = clone $this->app;
        
        $app->get('/', function (ServerRequestInterface $req, ResponseInterface $resp) {
            return $resp->getBody()->write('resolved');
        })->add(function (ServerRequestInterface $req, ResponseInterface $resp, callable $next) {
            $resp->getBody()->write('in');
            $resp = $next($req, $resp);
            $resp->getBody()->write('out');

            return $resp;
        });

        $response = $app->run(true);
                
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame('inresolvedout', (string) $response->getBody());
        
        return;
    }
}
