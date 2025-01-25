<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
use Nebalus\Webapi\Value\Module\Referral\ReferralCode;
use Nebalus\Webapi\Value\Pointer;

class EditReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private Pointer $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "path_args" => S::object([
                'code' => S::string()->required()->length(ReferralCode::LENGTH)->regex(ReferralCode::REGEX)
            ]),
            "body" => S::object([
                'pointer' => S::string()->nullable()->url(),
                'disabled' => S::boolean()->default(false),
            ])
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->referralCode = ReferralCode::from($validatedData->getPathArgsData()['code']);
        $this->pointer = Pointer::from($validatedData->getBodyData()['pointer']);
        $this->disabled = $validatedData->getBodyData()['disabled'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getPointer(): Pointer
    {
        return $this->pointer;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
