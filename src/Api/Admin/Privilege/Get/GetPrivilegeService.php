<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPrivilegeRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;

class GetPrivilegeService
{
    public function __construct(
        private readonly MySqlPrivilegeRepository $privilegeRepository,
        private readonly GetPrivilegeView $view
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function execute(GetPrivilegeValidator $validator): ResultInterface
    {
        $privilege = $this->privilegeRepository->findPrivilegeByPrivilegeId($validator->getPrivilegeId());

        if ($privilege === null) {
            return Result::createError("Privilege not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->view->render($privilege);
    }
}
