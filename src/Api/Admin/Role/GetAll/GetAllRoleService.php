<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;

readonly class GetAllRoleService
{
    public function __construct(
        private readonly GetAllRoleView $view,
        private readonly MySqlRoleRepository $roleRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(GetAllRoleValidator $validator): ResultInterface
    {
        $roles = $this->roleRepository->getAllRoles();

        return $this->view->render($roles);
    }
}
