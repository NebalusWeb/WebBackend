<?php

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegeRepository;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkIndex;
use Nebalus\Webapi\Value\User\User;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

readonly class PrivilegeMiddleware implements MiddlewareInterface
{
    public function __construct(
        private MySqlRoleRepository $roleRepository,
        private MySqlPrivilegeRepository $privilegeRepository,
    ) {
    }

    /**
     * @throws ApiException
     */
    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute('user');
        if ($user instanceof User === false) {
            return $handler->handle($request);
        }
        $unsortedRoles = $this->roleRepository->getAllRolesFromUserId($user->getUserId());
        $sortedRoles = $unsortedRoles->asSortedByAccessLevel();
        $roleLinkCollections = [];
        foreach ($sortedRoles as $role) {
            $roleLinkCollections[] = $this->roleRepository->getAllPrivilegeLinksFromRoleId($role->getRoleId());
        }
        $privilegeIndex = PrivilegeRoleLinkIndex::fromPrivilegeRoleLinkCollections(...$roleLinkCollections);
        $request = $request->withAttribute("userPrivilegeIndex", $privilegeIndex);
        return $handler->handle($request);
    }
}
