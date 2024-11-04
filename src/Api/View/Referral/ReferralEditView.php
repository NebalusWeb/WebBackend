<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralEditView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "referral_id" => $referral->getReferralId()->asInt(),
            "user_id" => $referral->getUserId()->asInt(),
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "creation_date" => $referral->getCreationDate()->getTimestamp(),
            "enabled" => $referral->isEnabled(),
        ];

        return Result::createSuccess("Referral edited", 200, $fields);
    }
}
