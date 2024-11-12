<?php

namespace Nebalus\Webapi\Api\Filter\Referral;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class ReferralDeleteFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ['code'];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $this->data = [
            "code" => $params['code'],
        ];

        return true;
    }
}
