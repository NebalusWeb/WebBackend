<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Sanitizr\Schema\AbstractSanitizrSchema;
use Nebalus\Sanitizr\Trait\SanitizrValueObjectTrait;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class UserAgent
{
    use SanitizrValueObjectTrait;

    public const string REGEX = "/\((?<info>.*?)\)(\s|$)|(?<name>.*?)\/(?<version>.*?)(\s|$)/";

    private function __construct(
        private readonly string $userAgent
    ) {
    }

    protected static function defineSchema(): AbstractSanitizrSchema
    {
        return S::string()->regex(self::REGEX);
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $userAgent): self
    {
        $schema = static::getSchema();
        $validData = $schema->safeParse($userAgent);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid useragent: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asString(): ?string
    {
        return $this->userAgent;
    }
}
