<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class CreateReferralView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "referral_id" => $referral->getReferralId()->asInt(),
            "owner_user_id" => $referral->getOwnerUserId()->asInt(),
            "code" => $referral->getCode()->asString(),
            "pointer" => $referral->getPointer()->asString(),
            "name" => $referral->getName()->asString(),
            "disabled" => $referral->isDisabled(),
            "created_at_timestamp" => $referral->getCreatedAtDate()->getTimestamp(),
            "updated_at_timestamp" => $referral->getUpdatedAtDate()->getTimestamp(),
        ];

        return Result::createSuccess("Referral created", 201, $fields);
    }
}
