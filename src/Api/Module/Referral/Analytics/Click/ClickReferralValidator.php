<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\Click;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\ValidatedData;

class ClickReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;

    public function __construct()
    {
        $rules = [
            "path_args" => [
                'code' => [ 'required' => true, 'nullable' => false, 'type' => "string" ]
            ],
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->referralCode = ReferralCode::from($validatedData->getPathArgsData()['code']);
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }
}
