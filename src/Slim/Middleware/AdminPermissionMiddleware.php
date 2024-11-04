<?php

namespace Nebalus\Webapi\Slim\Middleware;

use JsonException;
use Nebalus\Webapi\Value\Result\Result;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;


readonly class AdminPermissionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private App $app
    ) {
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        // TODO: Implement process() method.
    }

    /**
     * @throws JsonException
     */
    private function abort(string $errorMessage, int $code): Response
    {
        $result = Result::createError($errorMessage, $code);
        $response = $this->app->getResponseFactory()->createResponse();
        $response->withJson($result->getPayload());
        return $response;
    }
}
