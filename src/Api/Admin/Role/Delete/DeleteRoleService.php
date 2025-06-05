<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;

class DeleteRoleService
{
    public function __construct(
        private readonly MySQlRoleRepository $roleRepository,
        private readonly DeleteRoleView $view,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     * @throws ApiDateMalformedStringException
     */
    public function execute(DeleteRoleValidator $validator): ResultInterface
    {
        $role = $this->roleRepository->findRoleById($validator->getRoleId());

        if ($role === null) {
            return Result::createError('Role does not exist', StatusCodeInterface::STATUS_NOT_FOUND);
        }

        if ($role->isDeletable() === false) {
            return Result::createError('This role cannot be deleted', StatusCodeInterface::STATUS_FORBIDDEN);
        }

        if ($this->roleRepository->deleteRoleFromRoleId($validator->getRoleId())) {
            return $this->view->render();
        }

        return Result::createError('Role does not exist', StatusCodeInterface::STATUS_NOT_FOUND);
    }
}
