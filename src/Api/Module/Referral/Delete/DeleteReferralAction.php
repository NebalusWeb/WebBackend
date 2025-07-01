<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class DeleteReferralAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteReferralService $service,
        private readonly DeleteReferralValidator $validator
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects(
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OWN_DELETE, true),
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OTHER_DELETE, true),
        );
    }
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $requestingUser = $request->getAttribute('requestingUser');
        $result = $this->service->execute($this->validator, $requestingUser);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
