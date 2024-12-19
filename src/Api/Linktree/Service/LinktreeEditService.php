<?php

namespace Nebalus\Webapi\Api\Linktree\Service;

use Nebalus\Webapi\Api\Linktree\View\LinktreeEditView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeEditService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeEditView::render();
    }
}
