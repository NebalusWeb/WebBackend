<?php

namespace Nebalus\Webapi\Filter\Auth;

use Nebalus\Webapi\Filter\AbstractFilter;
use Override;

class AuthFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['username', 'password'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            $this->errorMessage = 'Authentication failed: missing credentials';
            return false;
        }

        $rememberMe = isset($params['remember_me']) ? filter_var($params['remember_me'], FILTER_VALIDATE_BOOLEAN) : false;
        $totp = $params['totp'] ?? "";

        $this->data = [
            'username' => $params['username'],
            'password' => $params['password'],
            'rememberMe' => $rememberMe,
            'totp' => $totp,
        ];

        return true;
    }
}
