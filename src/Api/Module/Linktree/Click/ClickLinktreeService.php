<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Click;

use Nebalus\Webapi\Api\Module\Linktree\Create\CreateLinktreeValidator;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class ClickLinktreeService
{
    public function __construct(
        private ClickLinktreeView $view,
    ) {
    }

    public function execute(CreateLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
