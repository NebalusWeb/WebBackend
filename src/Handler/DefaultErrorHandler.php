<?php

namespace Nebalus\Webapi\Handler;

use Nebalus\Webapi\Factory\ResponseFactory;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiErrorResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

class DefaultErrorHandler implements ErrorHandlerInterface
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $code = $exception->getCode() <= 599 && $exception->getCode() >= 100 ? $exception->getCode() : 500;

        $httpResponse = $this->responseFactory->createResponse($code);

        $apiResponse = ApiErrorResponse::from($exception->getMessage(), $code);

        $httpResponse->getBody()->write($apiResponse->getMessageAsJson());

        return $httpResponse;
    }
}
