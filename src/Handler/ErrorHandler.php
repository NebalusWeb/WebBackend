<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Handler;

use JsonException;
use Monolog\Logger;
use Nebalus\Webapi\Factory\ResponseFactory;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiErrorResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    private ResponseFactory $responseFactory;
    private Logger $errorLogger;

    public function __construct(ResponseFactory $responseFactory, Logger $errorLogger)
    {
        $this->responseFactory = $responseFactory;
        $this->errorLogger = $errorLogger;
    }

    /**
     * @throws JsonException
     */
    public function __invoke(
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $this->errorLogger->error($exception);

        $code = $exception->getCode() <= 599 && $exception->getCode() >= 100 ? $exception->getCode() : 500;

        $httpResponse = $this->responseFactory->createResponse($code);

        $apiResponse = ApiResponse::createError($exception->getMessage(), $code);

        $httpResponse->getBody()->write($apiResponse->getPayloadAsJson());

        return $httpResponse;
    }
}
