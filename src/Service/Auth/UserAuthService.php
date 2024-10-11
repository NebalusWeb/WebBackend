<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\Auth;

use Nebalus\Webapi\Filter\Auth\AuthFilter;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\View\Auth\AuthView;

readonly class UserAuthService
{
    public function __construct(
        private AuthFilter $authFilter,
    ) {
    }

    public function execute(array $params): ApiResponseInterface
    {
        if ($this->authFilter->filterAndCheckIfStructureIsValid($params) === false) {
            return ApiResponse::createError($this->authFilter->getErrorMessage(), 401);
        }

        $filteredData = $this->authFilter->getFilteredData();
        var_dump($filteredData);
        return AuthView::render();
    }
}
