<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\LinktreeCreateView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeCreateService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeCreateView::render();
    }
}
