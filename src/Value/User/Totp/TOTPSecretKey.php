<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Utils\Sanitizr\Sanitizr;
use Random\RandomException;

readonly class TOTPSecretKey
{
    public const string REGEX = '/^[\d\w]*$/';
    public const int LENGTH = 32; // Must be divisible by 2

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
            return self::from(strtoupper(bin2hex(random_bytes(self::LENGTH / 2))));
        } catch (RandomException $e) {
            throw new ApiInvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws ApiException
     */
    public static function from(string $secret): self
    {
        $schema = Sanitizr::string()->length(self::LENGTH)->regex(self::REGEX);
        $validData = $schema->safeParse($secret);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid totp secret: ' . $validData->getErrorMessage());
        }

        return new self($secret);
    }

    public function asString(): string
    {
        return $this->secret;
    }
}
