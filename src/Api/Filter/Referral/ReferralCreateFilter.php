<?php

namespace Nebalus\Webapi\Api\Filter\Referral;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class ReferralCreateFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = ["code", "pointer"];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $disabled = isset($params['disabled']) ? filter_var($params['disabled'], FILTER_VALIDATE_BOOLEAN) : false;

        $this->data = [
            "code" => $params['code'],
            "pointer" => $params['pointer'],
            "disabled" => $disabled,
        ];

        return true;
    }
}
