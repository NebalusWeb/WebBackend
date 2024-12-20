<?php

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;

class DeleteReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;

    public function __construct()
    {
        $rules = [
            "body" => [
                'code' => [ 'required' => true, 'nullable' => false, 'type' => "string" ]
            ],
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
