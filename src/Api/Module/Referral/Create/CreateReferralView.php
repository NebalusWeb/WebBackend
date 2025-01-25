<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\Module\Referral\Referral;

class CreateReferralView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "referral_id" => $referral->getReferralId()->asInt(),
            "code" => $referral->getCode()->asString(),
            "pointer" => $referral->getPointer()->asString(),
            "name" => $referral->getName()->asString(),
            "disabled" => $referral->isDisabled(),
            "created_at" => $referral->getCreatedAtDate()->format(DATE_ATOM),
            "updated_at" => $referral->getUpdatedAtDate()->format(DATE_ATOM),
        ];

        return Result::createSuccess("Referral created", 201, $fields);
    }
}
