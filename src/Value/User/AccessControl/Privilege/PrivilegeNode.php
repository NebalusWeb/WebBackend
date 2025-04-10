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
    public static function fromString(string $node): self
    {
        $destructuredNode = explode(' ', trim($node), 2);
        $schema = Sanitizr::batch(
            Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX),
            Sanitizr::number()->nullable()->integer()
        );
        $validData = $schema->safeParse($destructuredNode);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid privilege node: ' . $validData->getErrorMessage());
        }

        $parsedNode = $validData->getValue()[0];
        $parsedValue = $validData->getValue()[1];
        $grantAllSubPrivileges = str_ends_with($parsedNode, '*');
        $cleanedNode = str_replace(['.*', '*'], '', $parsedNode);

        return new self($cleanedNode, $grantAllSubPrivileges, $parsedValue);
    }
    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function areSubPrivilegesGranted(): bool
    {
        return $this->grantAllSubPrivileges;
    }

    public function asString(): string
    {
        return $this->node . ($this->areSubPrivilegesGranted() ? '.*' : '') . ($this->hasValue() ? ' ' . $this->value : '');
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
