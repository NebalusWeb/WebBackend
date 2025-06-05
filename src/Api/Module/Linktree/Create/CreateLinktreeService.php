<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Create;

use Nebalus\Webapi\Slim\ResultInterface;

readonly class CreateLinktreeService
{
    public function __construct(
        private CreateLinktreeView $view,
    )
    {
    }

    public function execute(CreateLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
