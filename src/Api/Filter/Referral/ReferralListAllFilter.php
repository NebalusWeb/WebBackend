<?php

namespace Nebalus\Webapi\Api\Filter\Referral;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class ReferralListAllFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = [];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $this->filteredData = [];

        return true;
    }
}
