<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Click;

use Nebalus\Webapi\Api\Module\Linktree\Create\CreateLinktreeValidator;
use Nebalus\Webapi\Slim\ResultInterface;

readonly class ClickLinktreeService
{
    public function __construct(
        private ClickLinktreeResponder $view,
    ) {
    }

    public function execute(CreateLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
