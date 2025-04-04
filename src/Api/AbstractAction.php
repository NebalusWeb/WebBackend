<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\User\User;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;
use Throwable;

abstract class AbstractAction
{
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): ResponseInterface {
        try {
            $authType = $request->getAttribute('authType');
            if ($authType === 'jwt') {
                $user = $request->getAttribute('user');

            }

            $response = $this->execute($request, $response, $args);
        } catch (ApiException $exception) {
            $result = Result::createFromException(
                $exception,
                $exception->getCode()
            );
            $response->getBody()->write($result->getPayloadAsJson());
            return $response->withStatus($result->getStatusCode());
        } catch (Throwable $exception) {
            $result = Result::createFromException(
                $exception
            );
            $response->getBody()->write($result->getPayloadAsJson());
            return $response->withStatus($result->getStatusCode());
        }
        return $response;
    }

    abstract protected function privilegeCheck(
        User $user
    ): bool;

    /**
     * @throws ApiException
     */
    abstract protected function execute(
        Request $request,
        Response $response,
        array $pathArgs
    ): Response;
}
