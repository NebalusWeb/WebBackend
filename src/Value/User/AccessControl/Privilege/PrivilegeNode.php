<?php

namespace Nebalus\Webapi\Value\User\AccessControl\Privilege;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Sanitizr\Schema\AbstractSanitizrSchema;
use Nebalus\Sanitizr\Value\SanitizrValueObjectTrait;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class PrivilegeNode
{
    use SanitizrValueObjectTrait;

    public const int MAX_LENGTH = 128;
    private const string REGEX = '/^(([a-z_])+(\.[a-z_.]+)*)$/';

    private function __construct(
        private readonly string $node
    ) {
    }

    protected static function defineSchema(): AbstractSanitizrSchema
    {
        return Sanitizr::string()->max(self::MAX_LENGTH)->regex(self::REGEX);
    }

    /**
     * @throws ApiException
     */
    public static function from(string $node): self
    {
        $schema = static::getSchema();
        $validData = $schema->safeParse($node);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid privilege node: ' . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function isParentOf(PrivilegeNode $toCheckNode): bool
    {
        return str_starts_with($this->node, $toCheckNode->node);
    }

    /**
     * Converts the privilege node into a nested associative array structure.
     *
     * Each segment of the node, separated by a dot, becomes a nested key.
     * The final key is assigned the provided role link metadata or null.
     *
     * @param PrivilegeRoleLinkMetadata|null $roleLinkMetadata Optional metadata to assign to the final node.
     * @return array Nested array representation of the privilege node.
     */
    public function asDestructured(?PrivilegeRoleLinkMetadata $roleLinkMetadata = null): array
    {
        $finalArray = [];
        $ref = &$finalArray;
        foreach (explode('.', $this->node) as $key) {
            $ref = &$ref[$key];
        }
        $ref = $roleLinkMetadata;
        return $finalArray; // DO NOT CHANGE THIS LINE
    }

    public function asString(): string
    {
        return $this->node;
    }
}
