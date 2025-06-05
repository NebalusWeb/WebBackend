<?php

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;

class DeleteReferralView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Referral deleted", StatusCodeInterface::STATUS_OK);
    }
}
