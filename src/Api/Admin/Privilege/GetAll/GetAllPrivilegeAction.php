<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\PrivilegeNodeTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetAllPrivilegeAction extends AbstractAction
{
    public function __construct(
        private GetAllPrivilegeService $service,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects(
            PrivilegeNode::from(PrivilegeNodeTypes::ADMIN_ROLE)
        );
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $result = $this->service->execute();
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
