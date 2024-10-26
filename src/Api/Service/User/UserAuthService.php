<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Service\User;

use DateMalformedStringException;
use InvalidArgumentException;
use Nebalus\Webapi\Api\Filter\User\UserAuthFilter;
use Nebalus\Webapi\Api\View\User\UserAuthView;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\MySqlUserInvitationTokenRepository;
use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\UserHashedPassword;
use Nebalus\Webapi\Value\User\Username;
use ReallySimpleJWT\Exception\BuildException;
use ReallySimpleJWT\Token;

readonly class UserAuthService
{
    public function __construct(
        private UserAuthFilter $authFilter,
        private MySqlUserRepository $mySqlUserRepository,
        private EnvData $envData
    ) {
    }

    /**
     * @throws DateMalformedStringException
     * @throws BuildException
     */
    public function execute(array $params): Result
    {
        if ($this->authFilter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->authFilter->getErrorMessage(), 401);
        }

        $filteredData = $this->authFilter->getFilteredData();

        try {
            $username = Username::from($filteredData['username']);
            $hashedPassword = UserHashedPassword::from($filteredData['password'], $this->envData->getPasswdHashKey());
        } catch (InvalidArgumentException) {
            return Result::createError('Authentication failed: Wrong credentials.', 401);
        }

        $user = $this->mySqlUserRepository->findUserByCredentials($username, $hashedPassword);

        if ($user === null) {
            return Result::createError('Authentication failed: Wrong credentials.', 401);
        }

        $expirationTime = time() + $this->envData->getJwtNormalExpirationTime();

        $token = Token::builder($this->envData->getJwtSecret())
            ->setPayloadClaim("user_id", $user->getUserId()->asInt())
            ->setPayloadClaim("is_admin", $user->isAdmin())
            ->setExpiration($expirationTime)
            ->setIssuer("api.nebalus.dev")
            ->setIssuedAt(time())
            ->build();

        return UserAuthView::render($token, $user);
    }
}
