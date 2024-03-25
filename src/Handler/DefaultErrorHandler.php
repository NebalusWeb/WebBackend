<?php

namespace Nebalus\Webapi\Handler;

use Nebalus\Webapi\ValueObject\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class DefaultErrorHandler implements ErrorHandlerInterface
{
    private JsonResponse $httpBodyJsonResponse;

    public function __construct(JsonResponse $httpBodyJsonResponse)
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
        $code = $exception->getCode() <= 599 && $exception->getCode() >= 100 ? $exception->getCode() : 500;

        $response = new Response($code);
        $response = $response->withAddedHeader("Content-Type", "application/json");

        $this->httpBodyJsonResponse->setStatus(-1);
        $this->httpBodyJsonResponse->setErrorMessage($exception->getMessage());

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response;
    }
}
