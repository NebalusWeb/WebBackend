<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralCreateView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "referral_id" => $referral->getReferralId()->asInt(),
            "user_id" => $referral->getUserId()->asInt(),
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "created_at_timestamp" => $referral->getCreatedAtDate()->getTimestamp(),
            "disabled" => $referral->isDisabled(),
        ];

        return Result::createSuccess("Referral created", 201, $fields);
    }
}
