<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\Referral\Referral;

class ReferralDeleteView
{
    public function render(): ApiResponseInterface
    {
        return ApiResponse::createSuccess([], 200);
    }
}
