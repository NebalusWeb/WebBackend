<?php

namespace Nebalus\Webapi\Api\Service\Linktree;

use Nebalus\Webapi\Api\View\Linktree\LinktreeDeleteView;
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
