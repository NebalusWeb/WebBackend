<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
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
                $userPrivileges = $request->getAttribute('userPrivileges');
                if ($userPrivileges instanceof PrivilegeCollection) {
                    $endpointPrivileges = $this->privilegeConfig();
                }
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

    abstract protected function privilegeConfig(): PrivilegeNodeCollection;

    /**
     * @throws ApiException
     */
    abstract protected function execute(
        Request $request,
        Response $response,
        array $pathArgs
    ): Response;
}
