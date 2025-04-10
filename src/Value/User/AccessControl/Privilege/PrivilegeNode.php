<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class PrivilegeNode
{
    public const int MAX_LENGTH = 128;
    private const string REGEX = '/^(([a-z_])+(\.[a-z_.*]+)*|\*)$/';

    private function __construct(
        private string $node,
        private bool $grantAllSubPrivileges,
        private ?int $value
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $node, bool $grantAllSubPrivileges, ?int $value = null): self
    {
        $schema = Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($node);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid privilege node: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue(), $grantAllSubPrivileges, $value);
    }
    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function isGrantingSubPrivileges(): bool
    {
        return $this->grantAllSubPrivileges;
    }

    public function getNode(): string
    {
        return $this->node;
    }

    public function isParentOf(PrivilegeNode $toCheckNode): bool
    {
        return str_starts_with($this->node, $toCheckNode->node);
    }
}
