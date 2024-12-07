<?php

namespace Nebalus\Webapi\Value\Referral;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class ReferralName
{

    private const int MAX_LENGTH = 32;
    private const string REGEX = '/^[a-zA-Z\w]+$/';

    private function __construct(
        private readonly ?string $referralName,
    ) {
    }
    /**
     * @throws ApiException
     */
    public static function from(?string $referralName): self
    {
        if (strlen($referralName) > self::MAX_LENGTH) {
            throw new ApiInvalidArgumentException(
                'Invalid referral name: cannot be longer than ' . self::MAX_LENGTH . ' characters'
            );
        }

        if (preg_match(self::REGEX, $referralName) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid referral name: can only contain letters'
            );
        }

        return new self($referralName);
    }
    public function asString(): ?string
    {
        return $this?->referralName;
    }
}
