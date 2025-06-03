<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PurePrivilegeNode;

class GetPrivilegeValidator extends AbstractValidator
{
    private PurePrivilegeNode $purePrivilegeNode;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "privilegeNode" => PurePrivilegeNode::getSchema(),
            ]),
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->purePrivilegeNode = PurePrivilegeNode::from($pathArgsData["privilegeNode"]);
    }

    public function getPurePrivilegeNode(): PurePrivilegeNode
    {
        return $this->purePrivilegeNode;
    }
}
