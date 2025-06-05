<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity\PrivilegeRoleLinkCollection;

class GetRoleService
{
    public function __construct(
        private readonly MySqlRoleRepository $roleRepository,
        private readonly GetRoleView $view
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function execute(GetRoleValidator $validator): ResultInterface
    {
        $role = $this->roleRepository->findRoleById($validator->getRoleId());

        if ($role === null) {
            return Result::createError("Role not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        if ($validator->isWithPrivileges()) {
            $privileges = $this->roleRepository->getAllPrivilegeLinksFromRoleId($validator->getRoleId());
            return $this->view->render($role, $privileges, $validator->isWithPrivileges());
        }

        return $this->view->render($role, PrivilegeRoleLinkCollection::fromObjects(), $validator->isWithPrivileges());
    }
}
