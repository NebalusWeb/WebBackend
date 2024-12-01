<?php

namespace Nebalus\Webapi\Api\Validator\Referral;

use Nebalus\Webapi\Api\Validator\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;

class ReferralGetValidator extends AbstractValidator
{
    private ReferralCode $referralCode;

    public function __construct()
    {
        $rules = [
            'code' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
        ];
        parent::__construct($rules);
    }

    protected function onValidate(array $filteredData): void
    {
        $this->referralCode = ReferralCode::from($filteredData['code']);
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }
}
