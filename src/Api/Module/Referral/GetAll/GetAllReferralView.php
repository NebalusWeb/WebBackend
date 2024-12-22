<?php

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Value\Referral\Referrals;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class GetAllReferralView
{
    public static function render(Referrals $referrals): ResultInterface
    {
        $fields = [];
        foreach ($referrals as $referral) {
            $fields[] = [
                "referral_id" => $referral->getReferralId()->asInt(),
                "owner_user_id" => $referral->getOwnerUserId()->asInt(),
                "code" => $referral->getCode()->asString(),
                "pointer" => $referral->getPointer()->asString(),
                "name" => $referral->getName()->asString(),
                "disabled" => $referral->isDisabled(),
                "created_at_timestamp" => $referral->getCreatedAtDate()->getTimestamp(),
                "updated_at_timestamp" => $referral->getUpdatedAtDate()->getTimestamp(),
            ];
        }

        return Result::createSuccess("List of referrals found", 200, $fields);
    }
}
