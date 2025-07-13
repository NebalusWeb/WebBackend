<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\User\Auth;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\GeneralConfig;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\UserRepository\MySqlUserRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use ReallySimpleJWT\Exception\BuildException;
use ReallySimpleJWT\Token;

readonly class AuthUserService
{
    public function __construct(
        private MySqlUserRepository $mySqlUserRepository,
        private GeneralConfig $generalConfig,
        private AuthUserResponder $responder,
    ) {
    }

    /**
     * @throws ApiException|BuildException
     */
    public function execute(AuthUserValidator $validator): ResultInterface
    {
        $user = $this->mySqlUserRepository->findUserFromUsername($validator->getUsername());

        if ($user === null || $user->isDisabled() || $user->getPassword()->verify($validator->getPassword()) === false) {
            return Result::createError('Authentication failed: Wrong credentials', StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $expirationTime = time() + $this->generalConfig->getJwtNormalExpirationTime();

        $token = Token::builder($this->generalConfig->getJwtSecret())
            ->setIssuer("https://api.nebalus.dev")
            ->setPayloadClaim("email", $user->getEmail()->asString())
            ->setPayloadClaim("username", $user->getUsername()->asString())
            ->setPayloadClaim("sub", $user->getUserId()?->asInt())
            ->setIssuedAt(time())
            ->setExpiration($expirationTime)
            ->build();

        return $this->responder->render($token, $user);
    }
}
