<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Internal\Validation\ValidRequestData;
use Nebalus\Webapi\Value\Module\Referral\ReferralName;
use Nebalus\Webapi\Value\Pointer;

class CreateReferralValidator extends AbstractValidator
{
    private ReferralName $referralName;
    private Pointer $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "body" => S::object([
                'name' => S::string(),
                'pointer' => S::string()->url(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidRequestData $request): void
    {
        $this->referralName = ReferralName::from($request->getBodyData()['name']);
        $this->pointer = Pointer::from($request->getBodyData()['pointer']);
        $this->disabled = $request->getBodyData()['disabled'];
    }

    public function getReferralName(): ReferralName
    {
        return $this->referralName;
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
