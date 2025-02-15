<?php

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\Module\Referral\Referrals;

class GetAllReferralView
{
    public static function render(Referrals $referrals): ResultInterface
    {
        $fields = [];
        foreach ($referrals as $referral) {
            $fields[] = [
                "referral_id" => $referral->getReferralId()->asInt(),
                "code" => $referral->getCode()->asString(),
                "url" => $referral->getUrl()->asString(),
                "name" => $referral->getName()->asString(),
                "disabled" => $referral->isDisabled(),
                "created_at" => $referral->getCreatedAtDate()->format(DATE_ATOM),
                "updated_at" => $referral->getUpdatedAtDate()->format(DATE_ATOM),
            ];
        }

        return Result::createSuccess("List of referrals found", 200, $fields);
    }
}
