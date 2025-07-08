<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Sanitizr\Schema\AbstractSanitizrSchema;
use Nebalus\Sanitizr\Trait\SanitizrValueObjectTrait;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

trait ID
{
    use SanitizrValueObjectTrait;

    private function __construct(
        private readonly int $id
    ) {
    }

    public static function defineSchema(): AbstractSanitizrSchema
    {
        return S::number()->integer()->positive();
    }

    /**
     * @throws ApiException
     */
    public static function from(mixed $id): self
    {
        $schema = static::getSchema();
        $validData = $schema->safeParse($id);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid id: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asInt(): int
    {
        return $this->id;
    }

    public function asString(): string
    {
        return (string) $this->id;
    }
}
