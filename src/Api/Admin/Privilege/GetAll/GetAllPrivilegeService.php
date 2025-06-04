<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegeRepository;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class GetAllPrivilegeService
{
    public function __construct(
        private GetAllPrivilegeView $view,
        private MySqlPrivilegeRepository $privilegeRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(): ResultInterface
    {
        $privileges = $this->privilegeRepository->getAllPrivileges();

        return $this->view->render($privileges);
    }
}
