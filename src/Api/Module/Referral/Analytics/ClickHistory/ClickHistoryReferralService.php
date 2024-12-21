<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Value\Result\ResultInterface;

class ClickHistoryReferralService
{


    public function execute(ClickHistoryReferralValidator $validator): ResultInterface
    {

        return ClickHistoryReferralView::render();
    }
}
