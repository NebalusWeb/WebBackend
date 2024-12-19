<?php

namespace Nebalus\Webapi\Api\Linktree\Service;

use Nebalus\Webapi\Api\Linktree\View\LinktreeDeleteView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeDeleteService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeDeleteView::render();
    }
}
