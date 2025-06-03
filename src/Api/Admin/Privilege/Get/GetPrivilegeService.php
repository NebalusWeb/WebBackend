<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegesRepository;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class GetPrivilegeService
{
    public function __construct(
        private MySqlPrivilegesRepository $privilegesRepository,
        private GetPrivilegeView $view
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function execute(GetPrivilegeValidator $validator): ResultInterface
    {
        $privilege = $this->privilegesRepository->findPrivilegeByNode($validator->getPurePrivilegeNode());

        if ($privilege === null) {
            return Result::createError("Privilege not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->view->render($privilege);
    }
}
