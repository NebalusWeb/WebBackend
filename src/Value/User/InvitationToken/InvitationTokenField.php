<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class InvitationTokenField
{
    private function __construct(
        private string $valueAsString,
        private int $valueAsInt,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function create(): self
    {
        return self::from(rand(0, 9999));
    }

    /**
     * @throws ApiException
     */
    public static function from(int $value): self
    {
        if ($value < 0 || $value > 9999) {
            throw new ApiInvalidArgumentException('Invalid token value: can be exactly or between 0 and 9999');
        }

        return new self(self::stringifyValue($value), $value);
    }

    public function asString(): string
    {
        return $this->valueAsString;
    }

    public function asInt(): int
    {
        return $this->valueAsInt;
    }

    private static function stringifyValue(string $value): string
    {
        if (strlen($value) === 1) {
            $value = "000" . $value;
        }

        if (strlen($value) === 2) {
            $value = "00" . $value;
        }

        if (strlen($value) === 3) {
            $value = "0" . $value;
        }
        return $value;
    }
}
