<?php

namespace Nebalus\Webapi\Handler;

use Nebalus\Webapi\ValueObjects\HttpBodyJsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class DefaultErrorHandler implements ErrorHandlerInterface
{
    private HttpBodyJsonResponse $httpBodyJsonResponse;

    public function __construct(HttpBodyJsonResponse $httpBodyJsonResponse)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {

        $response = new Response($exception->getCode());
        $response = $response->withAddedHeader("Content-Type", "application/json");

        // Default
        $this->httpBodyJsonResponse->setSuccess(false);
        $this->httpBodyJsonResponse->setStatusCode($response->getStatusCode());

        // Error Message
        $this->httpBodyJsonResponse->setErrorMessage($exception->getMessage());

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response;
    }
}
