<?php

namespace Nebalus\Webapi\Api\Referral\Create;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;

class CreateReferralValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private ?string $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            "body" => [
                'code' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
                'pointer' => [ 'required' => true, 'nullable' => true, 'type' => "string" ],
                'disabled' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => "boolean" ],
            ]
        ];
        parent::__construct($rules);
    }

    protected function onValidate(array $filteredData): void
    {
        $this->referralCode = ReferralCode::from($filteredData['code']);
        $this->pointer = $filteredData['pointer'];
        $this->disabled = $filteredData['disabled'];
    }

    public function getReferralCode(): ReferralCode
    {
        return $this->referralCode;
    }

    public function getPointer(): ?string
    {
        return $this->pointer;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
