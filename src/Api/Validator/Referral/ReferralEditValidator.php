<?php

namespace Nebalus\Webapi\Api\Validator\Referral;

use Nebalus\Webapi\Api\Validator\AbstractValidator;
use Nebalus\Webapi\Value\Referral\ReferralCode;

class ReferralEditValidator extends AbstractValidator
{
    private ReferralCode $referralCode;
    private ?string $pointer;
    private bool $disabled;

    public function __construct()
    {
        $rules = [
            'code' => [ 'required' => true, 'nullable' => false, 'datatype' => "string" ],
            'pointer' => [ 'required' => false, 'nullable' => true, 'datatype' => "string" ],
            'disabled' => [ 'required' => false, 'nullable' => false, 'default' => false, 'datatype' => "boolean" ],
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
