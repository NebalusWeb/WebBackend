<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Role;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Sanitizr\Schema\AbstractSanitizrSchema;
use Nebalus\Sanitizr\Value\SanitizrValueObjectTrait;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class RoleAccessLevel
{
    use SanitizrValueObjectTrait;

    public function __construct(
        private readonly int $accessLevel,
    ) {
    }

    protected static function defineSchema(): AbstractSanitizrSchema
    {
        return Sanitizr::number()->integer()->nonNegative();
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $accessLevel): self
    {
        $schema = static::getSchema();
        $validData = $schema->safeParse($accessLevel);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid accessLevel: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asInt(): int
    {
        return $this->accessLevel;
    }
}
