<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Service\User;

use DateMalformedStringException;
use InvalidArgumentException;
use Nebalus\Webapi\Api\Filter\User\UserAuthFilter;
use Nebalus\Webapi\Api\View\User\UserAuthView;
use Nebalus\Webapi\Exception\ApiDatabaseException;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\Username;
use ReallySimpleJWT\Exception\BuildException;
use ReallySimpleJWT\Token;

readonly class UserAuthService
{
    public function __construct(
        private UserAuthFilter $filter,
        private MySqlUserRepository $mySqlUserRepository,
        private EnvData $envData
    ) {
    }

    /**
     * @throws DateMalformedStringException
     * @throws BuildException
     * @throws ApiDatabaseException
     */
    public function execute(array $params): ResultInterface
    {
        if ($this->filter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->filter->getErrorMessage(), 401);
        }

        $filteredData = $this->filter->getFilteredData();

        try {
            $username = Username::from($filteredData['username']);
        } catch (InvalidArgumentException) {
            return Result::createError('Authentication failed: Wrong credentials.', 401);
        }

        $user = $this->mySqlUserRepository->getUserFromUsername($username);

        if ($user === null) {
            return Result::createError('Authentication failed: Wrong credentials.', 401);
        }

        if ($user->getPassword()->verify($filteredData['password'], (string)$user->getCreatedAtDate()->getTimestamp()) === false) {
            return Result::createError('Authentication failed: Wrong credentials.', 401);
        }

        $expirationTime = time() + $this->envData->getJwtNormalExpirationTime();

        $token = Token::builder($this->envData->getJwtSecret())
            ->setIssuer("NebalusWebApi")
            ->setPayloadClaim("email", $user->getEmail())
            ->setPayloadClaim("sub", $user->getUserId()->asInt())
            ->setPayloadClaim("sub", $user->getUserId()->asInt())
            ->setIssuedAt(time())
            ->setExpiration($expirationTime)
            ->build();

        return UserAuthView::render($token, $user);
    }
}
