<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class PrivilegeNode
{
    public const MAX_LENGTH = 128;
    private const string REGEX = '/^[a-z.]+$/';

    private function __construct(
        private string $node
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(string $node): self
    {
        $schema = Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($node);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid privilege node: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asString(): string
    {
        return $this->node;
    }
}
