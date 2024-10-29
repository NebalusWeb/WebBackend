<?php

namespace Nebalus\Webapi\Api\Filter\Referral;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class ReferralClickFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['code'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            $this->errorMessage = 'Please give a valid referral code';
            return false;
        }

        $this->data = [
            'code' => $params['code'],
        ];

        return true;
    }
}
