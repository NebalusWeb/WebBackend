<?php

namespace Nebalus\Webapi\Value\Referral;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class ReferralCode
{
    public const int CODE_LENGTH = 8;
    public const string REGEX = '/^[0-9A-Za-z]+$/';

    private function __construct(
        private readonly string $code
    ) {
    }

    public static function create(): self
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return new self(substr(str_shuffle($str_result), 0, self::CODE_LENGTH));
    }

    /**
     * @throws ApiException
     */
    public static function from(string $code): self
    {
        if (preg_match(self::REGEX, $code) === false) {
            throw new ApiInvalidArgumentException(
                'Invalid referral code: can only contain alphanumeric characters'
            );
        }

        return new self($code);
    }

    public function asString(): string
    {
        return $this->code;
    }
}
