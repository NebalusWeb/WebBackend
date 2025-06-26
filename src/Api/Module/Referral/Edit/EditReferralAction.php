<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class EditReferralAction extends AbstractAction
{
    public function __construct(
        private readonly EditReferralService $service,
        private readonly EditReferralValidator $validator,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects(
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OWN_EDIT, true),
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OTHER_EDIT, true),
        );
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $requestingUser = $request->getAttribute('requestingUser');
        $userPermissionIndex = $request->getAttribute('userPermissionIndex');
        $result = $this->service->execute($this->validator, $requestingUser, $userPermissionIndex);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
