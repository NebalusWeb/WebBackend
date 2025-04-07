<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class RoleName
{
    public const int MIN_LENGTH = 4;
    public const int MAX_LENGTH = 32;
    public const string REGEX = '/^[a-zA-Z0-9_]+$/';

    public function __construct(
        private readonly string $roleName
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(string $roleName): self
    {
        $schema = Sanitizr::string()->min(self::MIN_LENGTH)->max(self::MAX_LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($roleName);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid role name: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asString(): string
    {
        return $this->roleName;
    }
}
