<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidRequestData;
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
                'code' => S::string()->length(ReferralCode::LENGTH)->regex(ReferralCode::REGEX)
            ]),
            "body" => S::object([
                'pointer' => S::string()->optional()->nullable()->url(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidRequestData $request): void
    {
        $this->referralCode = ReferralCode::from($request->getPathArgsData()['code']);
        $this->pointer = Pointer::from($request->getBodyData()['pointer']);
        $this->disabled = $request->getBodyData()['disabled'];
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
