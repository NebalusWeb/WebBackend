<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;

readonly class CreateRoleService
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
