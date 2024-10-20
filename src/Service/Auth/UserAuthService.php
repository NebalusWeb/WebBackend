<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\Auth;

use DateMalformedStringException;
use InvalidArgumentException;
use Nebalus\Webapi\Filter\Auth\AuthFilter;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\MySqlUserInvitationTokenRepository;
use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\User\UserHashedPassword;
use Nebalus\Webapi\ValueObject\User\Username;
use Nebalus\Webapi\View\Auth\AuthView;
use ReallySimpleJWT\Exception\BuildException;
use ReallySimpleJWT\Token;

readonly class UserAuthService
{
    public function __construct(
        private AuthFilter $authFilter,
        private MySqlUserRepository $mySqlUserRepository,
        private MySqlUserInvitationTokenRepository $mySqlUserInvitationTokenRepository,
        private EnvData $envData
    ) {
    }

    /**
     * @throws DateMalformedStringException
     * @throws BuildException
     */
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

        $user = $this->mySqlUserRepository->findUserByCredentials($username, $hashedPassword);

        if ($user === null) {
            return ApiResponse::createError('Authentication failed: Wrong credentials.', 401);
        }

        $expirationTime = time() + $this->envData->getJwtNormalExpirationTime();

        $token = Token::builder($this->envData->getJwtSecret())
            ->setPayloadClaim("user_id", $user->getUserId()->asInt())
            ->setPayloadClaim("is_admin", $user->isAdmin())
            ->setExpiration($expirationTime)
            ->setIssuer("api.nebalus.dev")
            ->setIssuedAt(time())
            ->build();

        return AuthView::render($token, $user);
    }
}
