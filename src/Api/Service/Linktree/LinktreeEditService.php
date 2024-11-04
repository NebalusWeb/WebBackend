<?php

namespace Nebalus\Webapi\Api\Service\Linktree;

use Nebalus\Webapi\Api\View\Linktree\LinktreeEditView;
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
