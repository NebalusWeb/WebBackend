<?php

namespace Nebalus\Webapi\Api;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

abstract class AbstractAction
{
    /**
     * @throws ApiException
     */
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): ResponseInterface {
        $authType = $request->getAttribute('authType');
        if ($authType === 'jwt') {
            $userPermissionIndex = $request->getAttribute('userPermissionIndex');
            if ($userPermissionIndex instanceof UserPermissionIndex) {
                $endpointAccessGuard = $this->endpointAccessGuard();
                if ($endpointAccessGuard !== null && $userPermissionIndex->hasAccessToAtLeastOneNode($endpointAccessGuard) === false) {
                    $result = Result::createError("You do not have enough permissions to access this endpoint", StatusCodeInterface::STATUS_FORBIDDEN);
                    return $response->withJson($result->getPayload(), $result->getStatusCode());
                }
            }
        }
        return $this->execute($request, $response, $args);
    }

    /**
     * @throws ApiException
     */
    abstract protected function execute(
        Request $request,
        Response $response,
        array $pathArgs
    ): Response;

    protected function endpointAccessGuard(): ?PermissionAccessCollection
    {
        return null;
    }
}
