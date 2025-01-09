<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class TOTPCode
{
    private function __construct(
        private string $code,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(string $code): self
    {
        $totpCodePattern = '/^[\d]{6}$/';
        if (preg_match($totpCodePattern, $code) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid totp code'
            );
        }
        return new self($code);
    }

    private function asString(): string
    {
        return $this->code;
    }
}
