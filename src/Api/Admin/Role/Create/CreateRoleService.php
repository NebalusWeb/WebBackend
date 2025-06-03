<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class CreateRoleService
{
    public function __construct(
        private MySqlRoleRepository $roleRepository,
        private CreateRoleView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(CreateRoleValidator $validator): ResultInterface
    {
        return Result::createSuccess("");
    }
}
