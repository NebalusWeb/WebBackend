<?php

namespace Nebalus\Webapi\Api\Filter\User;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class UserRegisterFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['invitation_token', 'email', 'username', 'password'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $this->filteredData = [
            'invitation_token' => $params['invitation_token'],
            'email' => $params['email'],
            'username' => $params['username'],
            'password' => $params['password'],
        ];

        return true;
    }
}
