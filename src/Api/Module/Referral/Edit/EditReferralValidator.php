<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
use Nebalus\Webapi\Value\Internal\Validation\ValidType;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Referral\ReferralPointer;

class EditReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private ReferralPointer $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "path_args" => [
                'code' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
            ],
            "body" => [
                'pointer' => [ 'required' => false, 'nullable' => true, 'type' => ValidType::STRING ],
                'disabled' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => ValidType::BOOLEAN ],
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
