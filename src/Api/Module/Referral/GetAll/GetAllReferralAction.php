<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class GetAllReferralAction extends AbstractAction
{
    public function __construct(
        private readonly GetAllReferralService $service
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects(
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OWN, true),
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OTHER, true),
        );
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ApiException
     */
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $requestingUser = $request->getAttribute('requestingUser');
        $result = $this->service->execute($requestingUser);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
