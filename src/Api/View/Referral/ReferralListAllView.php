<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Referral\Referrals;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralListAllView
{
    public static function render(Referrals $referrals): ResultInterface
    {
        $fields = [];
        foreach ($referrals as $referral) {
            $fields[] = [
                "referral_id" => $referral->getReferralId()->asInt(),
                "user_id" => $referral->getUserId()->asInt(),
                "code" => $referral->getCode(),
                "pointer" => $referral->getPointer(),
                "disabled" => $referral->isDisabled(),
                "created_at_timestamp" => $referral->getCreatedAtDate()->getTimestamp(),
                "updated_at_timestamp" => $referral->getUpdatedAtDate()->getTimestamp(),
            ];
        }

        return Result::createSuccess("List of referrals found", 200, $fields);
    }
}
