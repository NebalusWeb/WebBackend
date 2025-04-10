<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class PrivilegeNode
{
    public const MAX_LENGTH = 128;
    private const string REGEX = '/^(([a-z_])+(\.[a-z_.*]+)*|\*)(\s-?\d+)?$/';

    private function __construct(
        private string $node,
        private ?int $value
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $node): self
    {
        $schema = Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($node);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid privilege node: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue(), null);
    }

    public function asString(): string
    {
        return $this->node;
    }

    public function areSubPrivilegesGranted(): bool
    {
        return str_ends_with($this->node, '*');
    }

    // TODO: NOT FINISHED
    public function contains(PrivilegeNode $toCheckNode): bool
    {
        if ($this->areSubPrivilegesGranted()) {
            return str_starts_with($toCheckNode->asString(), $this->node);
        }

        return false;
    }
}
