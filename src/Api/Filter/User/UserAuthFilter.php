<?php

namespace Nebalus\Webapi\Api\Filter\User;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class UserAuthFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['username', 'password'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $rememberMe = isset($params['remember_me']) ? filter_var($params['remember_me'], FILTER_VALIDATE_BOOLEAN) : false;

        $this->filteredData = [
            'username' => $params['username'],
            'password' => $params['password'],
            'rememberMe' => $rememberMe,
            'totp' => $params['totp'],
        ];

        return true;
    }
}
