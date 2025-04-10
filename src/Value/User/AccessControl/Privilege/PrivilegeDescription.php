<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class PrivilegeDescription
{
    public const int MAX_LENGTH = 255;
    public const string REGEX = '/^[\w\d_.-\s]+$/g';

    public function __construct(
        private string $description,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $description): self
    {
        $description = trim($description);

        $schema = Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($description);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid description: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asString(): string
    {
        return $this->description;
    }
}
