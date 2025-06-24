<?php

namespace Nebalus\Webapi\Slim\Middleware;

use Exception;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegeRepository;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkIndex;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleSortedCollection;
use Nebalus\Webapi\Value\User\User;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

readonly class PrivilegeMiddleware implements MiddlewareInterface
{
    public function __construct(
        private MySqlRoleRepository $roleRepository
    ) {
    }

    /**
     * @throws ApiException
     * @throws Exception
     */
    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute('user');
        if ($user instanceof User === false) {
            return $handler->handle($request);
        }
        $unsortedRoles = $this->roleRepository->getAllRolesFromUserId($user->getUserId());
        $sortedRoles = RoleSortedCollection::fromRoleCollectionByAccessLevel($unsortedRoles);
        $sortedRoleLinkCollections = [];
        foreach ($sortedRoles as $role) {
            $sortedRoleLinkCollections[] = $this->roleRepository->getAllPrivilegeLinksFromRoleId($role->getRoleId());
        }
        $userPrivilegeIndex = PrivilegeRoleLinkIndex::fromPrivilegeRoleLinkCollections(...$sortedRoleLinkCollections);
        $request = $request->withAttribute("userPrivilegeIndex", $userPrivilegeIndex);
        return $handler->handle($request);
    }
}
