<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Referral\ReferralName;
use Nebalus\Webapi\Value\Referral\ReferralPointer;
use Nebalus\Webapi\Value\ValidatedData;

class CreateReferralValidator extends AbstractValidator
{
    private ReferralName $referralName;
    private ReferralPointer $referralPointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "body" => [
                'name' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
                'pointer' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
                'disabled' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => "boolean" ],
            ]
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->referralName = ReferralName::from($validatedData->getBodyData()['name']);
        $this->referralPointer = ReferralPointer::from($validatedData->getBodyData()['pointer']);
        $this->disabled = $validatedData->getBodyData()['disabled'];
    }

    public function getReferralName(): ReferralName
    {
        return $this->referralName;
    }

    public function getReferralPointer(): ReferralPointer
    {
        return $this->referralPointer;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
