<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\Referral\Click\ReferralClick;
use Nebalus\Webapi\Value\Referral\Click\ReferralClicks;

class ClickHistoryReferralView
{
    public static function render(ReferralClicks $referralClicks): ResultInterface
    {
        $fields = [];
        foreach ($referralClicks as $referralClick) {
            if ($referralClick instanceof ReferralClick === false) {
                continue;
            }

            $fields[] = [
                "date" => $referralClick->getClickedAt()->format("Y-m-d"),
                "click_amount" => $referralClick->getClickAmount(),
            ];
        }


        return Result::createSuccess("Referral history found", 200, $fields);
    }
}
