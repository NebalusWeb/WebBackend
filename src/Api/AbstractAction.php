<?php

namespace Nebalus\Webapi\Api;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkIndex;
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
            $userPrivilegesIndex = $request->getAttribute('userPrivilegeIndex');
            if ($userPrivilegesIndex instanceof PrivilegeRoleLinkIndex) {
                $endpointPrivileges = $this->privilegeConfig();
                if ($userPrivilegesIndex->containsSomeNodes($endpointPrivileges) === false) {
                    $result = Result::createError("You are not allowed to access this endpoint", StatusCodeInterface::STATUS_FORBIDDEN);
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

    abstract protected function privilegeConfig(): PrivilegeNodeCollection;
}
