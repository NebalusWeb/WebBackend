<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class InvitationTokenField
{
    private function __construct(
        private string $fieldAsString,
        private int $fieldAsInt,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(int $tokenField): self
    {
        if ($tokenField < 0 || $tokenField > 9999) {
            throw new ApiInvalidArgumentException('Invalid tokenField: can be exactly or between 0 and 9999');
        }

        $stringifyToken = (string) $tokenField;
        if (strlen($stringifyToken) === 1) {
            $stringifyToken = "000" . $stringifyToken;
        }

        if (strlen($stringifyToken) === 2) {
            $stringifyToken = "00" . $stringifyToken;
        }

        if (strlen($stringifyToken) === 3) {
            $stringifyToken = "0" . $stringifyToken;
        }
        return new self($stringifyToken, $tokenField);
    }

    public function asString(): string
    {
        return $this->fieldAsString;
    }

    public function asInt(): int
    {
        return $this->fieldAsInt;
    }
}
