<?php

namespace Nebalus\Webapi\Api\Linktree\Service\Analytics;

use Nebalus\Webapi\Api\Linktree\View\Analytics\LinktreeClickView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeClickService
{
    public function __construct()
    {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeClickView::render();
    }
}
