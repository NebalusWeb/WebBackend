<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegesRepository;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeCollection;

class GetAllPrivilegeService
{
    public function __construct(
        private GetAllPrivilegeView $view,
        private MySqlPrivilegesRepository $privilegesRepository
    ) {
    }

    public function execute(): ResultInterface
    {
        $privileges = $this->privilegesRepository->getPrivileges();

        return $this->view->render($privileges);
    }
}
