<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegesRepository;

class GetAllPrivilegeService
{
    public function __construct(
        private GetAllPrivilegeView $view,
        private MySqlPrivilegesRepository $privilegesRepository
    ) {
    }
}
