<?php

namespace Nebalus\Ownsite\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonValidatorMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();

        $response->getBody()->write('BEFORE');
        $response->getBody()->write('AFTER');

        return $response;
    }
}
