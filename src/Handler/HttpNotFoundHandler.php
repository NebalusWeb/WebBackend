<?php

namespace Nebalus\Webapi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class HttpNotFoundHandler implements ErrorHandlerInterface
{
    private Response $response;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        return $this->response->withStatus(404);
    }
}
