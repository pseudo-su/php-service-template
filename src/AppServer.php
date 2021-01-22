<?php

namespace Pseudo\PhpServiceTemplate;

use React\Http\Server as HttpServer;
use React\EventLoop\LoopInterface;
use React\Http\Message\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use React\Promise;
use React\Promise\PromiseInterface;

class AppServer
{
    public function __construct(
        // phpcs:disable
        private LoopInterface $loop,
        // phpcs:enable
    ) {
    }

    public function getUri(): string
    {
        $port = getenv('PORT') ?: 8080;
        $portString = $port ? ':' . $port : '';
        $uri = '0.0.0.0' . $portString;

        return $uri;
    }

    public function build(): HttpServer
    {
        $middlewareFn = function (ServerRequestInterface $request, callable $next): PromiseInterface {
            $promise = Promise\resolve($next($request));
            return $promise->then(function (ResponseInterface $response) {
                return $response->withHeader('Content-Type', 'application/json');
            });
        };
        $appHandlerFn = function (ServerRequestInterface $request): Response {
            return new Response(200, [], '{}');
        };

        return new HttpServer($this->loop, $middlewareFn, $appHandlerFn);
    }
}
