<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;

class CreateRoleService
{
    public function __construct(
        private readonly MySqlRoleRepository $roleRepository,
        private readonly CreateRoleView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(CreateRoleValidator $validator): ResultInterface
    {
        $role = Role::create($validator->getRoleName(), $validator->getRoleDescription(), $validator->getRoleColor(), $validator->getAccessLevel(), $validator->appliesToEveryone(), $validator->isDisabled());
        $role = $this->roleRepository->insertRole($role);
        return $this->view->render($role);
    }
}
