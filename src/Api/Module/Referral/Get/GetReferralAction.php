<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class GetReferralAction extends AbstractAction
{
    public function __construct(
        private readonly GetReferralService $service,
        private readonly GetReferralValidator $validator
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects(
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OWN, true),
            PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OTHER_SEE, true),
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
