<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Referral\ReferralPointer;
use Nebalus\Webapi\Value\ValidatedData;

class EditReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private ReferralPointer $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "path_args" => [
                'code' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
            ],
            "body" => [
                'pointer' => [ 'required' => false, 'nullable' => true, 'type' => "string" ],
                'disabled' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => "boolean" ],
            ]
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->referralCode = ReferralCode::from($validatedData->getPathArgsData()['code']);
        $this->pointer = ReferralPointer::from($validatedData->getBodyData()['pointer']);
        $this->disabled = $validatedData->getBodyData()['disabled'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getPointer(): ReferralPointer
    {
        return $this->pointer;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
