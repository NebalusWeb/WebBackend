<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

class GetAllRoleService
{
    public function __construct(
        private GetAllPrivilegeView $view,
        private MySqlPrivilegesRepository $privilegesRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(): ResultInterface
    {
        $roles = $this->privilegesRepository->getPrivileges();

        return $this->view->render($privileges);
    }
}