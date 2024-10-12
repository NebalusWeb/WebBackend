<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\Auth;

use InvalidArgumentException;
use Nebalus\Webapi\Filter\Auth\AuthFilter;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\User\UserHashedPassword;
use Nebalus\Webapi\ValueObject\User\Username;
use Nebalus\Webapi\View\Auth\AuthView;

readonly class UserAuthService
{
    public function __construct(
        private AuthFilter $authFilter,
        private EnvData $envData
    ) {
    }

    public function execute(array $params): ApiResponseInterface
    {
        if ($this->authFilter->filterAndCheckIfStructureIsValid($params) === false) {
            return ApiResponse::createError($this->authFilter->getErrorMessage(), 401);
        }

        $filteredData = $this->authFilter->getFilteredData();
        try {
            $username = Username::from($filteredData['username']);
            $hashedPassword = UserHashedPassword::from($filteredData['password'], $this->envData->getPasswdHashKey());
        } catch (InvalidArgumentException) {
            return ApiResponse::createError('Authentication failed: Wrong credentials.', 401);
        }

        var_dump($filteredData);
        return AuthView::render();
    }
}
