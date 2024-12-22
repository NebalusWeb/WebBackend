<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Analytics\Click;

use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ClickLinktreeService
{
    public function __construct()
    {
    }

    public function execute(array $params): ResultInterface
    {
        return ClickLinktreeView::render();
    }
}
