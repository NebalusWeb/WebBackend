<?php

namespace Nebalus\Webapi\Api\Module\Referral\Get;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class GetReferralView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "referral_id" => $referral->getReferralId()->asInt(),
            "user_id" => $referral->getUserId()->asInt(),
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "disabled" => $referral->isDisabled(),
            "created_at_timestamp" => $referral->getCreatedAtDate()->getTimestamp(),
            "updated_at_timestamp" => $referral->getUpdatedAtDate()->getTimestamp(),
        ];

        return Result::createSuccess("Referral fetched", 200, $fields);
    }
}
