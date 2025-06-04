<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity\PrivilegeNodeCollection;
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
            /*
            $userPrivileges = $request->getAttribute('userPrivileges');
            if ($userPrivileges instanceof PrivilegeNodeCollection) {
                $endpointPrivileges = $this->privilegeConfig();
                if ($userPrivileges->containsSomeNodes($endpointPrivileges) === false) {
                    $result = Result::createError("You are not allowed to access this endpoint", StatusCodeInterface::STATUS_FORBIDDEN);
                    return $response->withJson($result->getPayload(), $result->getStatusCode());
                }
            }
            */
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
