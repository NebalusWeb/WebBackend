<?php

namespace Nebalus\Webapi\Api\User\GetUserPermissions;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Value\User\UserId;

class GetUserPermissionsValidator extends AbstractValidator
{
    private ?UserId $userId;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "userId" => S::string()->equals("self")->or(UserId::getSchema()),
            ]),
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->userId = isset($pathArgsData["userId"]) && $pathArgsData["userId"] === "self" ? null : UserId::from($pathArgsData["userId"]);
    }

    public function getUserId(): ?UserId
    {
        return $this->userId;
    }
}
