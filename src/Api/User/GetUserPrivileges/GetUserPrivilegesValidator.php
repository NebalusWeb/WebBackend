<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Sanitizr\Sanitizr as S;

class GetUserPrivilegesValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct(S::object([]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        // TODO: Implement onValidate() method.
    }
}
