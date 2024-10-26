<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\Value\ApiResponse\ApiResponse;
use Nebalus\Webapi\Value\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\Value\Referral\Referral;

class ReferralDeleteView
{
    public function render(): ApiResponseInterface
    {
        return ApiResponse::createSuccess([], 200);
    }
}
