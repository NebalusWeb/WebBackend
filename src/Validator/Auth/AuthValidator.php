<?php

namespace Nebalus\Webapi\Validator\Auth;

use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Validator\AbstractValidator;

class AuthValidator extends AbstractValidator
{
    public function __construct(
        private readonly EnvData $envData,
    ) {
        parent::__construct();
    }

    public function validate()
    {
    }
}
