<?php

namespace Nebalus\Webapi\Handler;

use Nebalus\Webapi\ValueObjects\HttpBodyJsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class HttpErrorHandler implements ErrorHandlerInterface
{
    private Response $response;
    private HttpBodyJsonResponse $httpBodyJsonResponse;

    public function __construct(Response $response, HttpBodyJsonResponse $httpBodyJsonResponse)
    {
        $this->response = $response;
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {

        $response = $this->response->withStatus($exception->getCode());

        // Default
        $this->httpBodyJsonResponse->setSuccess(false);
        $this->httpBodyJsonResponse->setStatusCode($response->getStatusCode());

        // Error Message
        $this->httpBodyJsonResponse->setErrorMessage();

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response;
    }
}
