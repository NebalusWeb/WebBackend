<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeId;

class GetPrivilegeValidator extends AbstractValidator
{
    private PrivilegeId $privilegeId;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "privilegeId" => PrivilegeId::getSchema(),
            ]),
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->privilegeId = PrivilegeId::from($pathArgsData["privilegeId"]);
    }

    public function getPrivilegeId(): PrivilegeId
    {
        return $this->privilegeId;
    }
}
