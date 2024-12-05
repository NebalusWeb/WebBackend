<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Random\RandomException;

readonly class TOTPSecretKey
{
    private function __construct(
        private string $secret
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function create(): self
    {
        try {
            return self::from(strtoupper(bin2hex(random_bytes(16))));
        } catch (RandomException $e) {
            throw new ApiInvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws ApiException
     */
    public static function from(string $secret): self
    {
        $usernamePattern = '/^[\d\w]{32}$/';
        if (preg_match($usernamePattern, $secret) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid totp code secret'
            );
        }
        return new self($secret);
    }

    public function asString(): string
    {
        return $this->secret;
    }
}
