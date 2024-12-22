<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

use function strlen;

readonly class UserPassword
{
    private const int MIN_LENGTH = 8;
    private const int MAX_LENGTH = 64;

    private function __construct(
        private string $passwordHash
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromPlain(string $plainPassword, int $cost = 10): self
    {
        if (strlen($plainPassword) < self::MIN_LENGTH) {
            throw new ApiInvalidArgumentException('Invalid password: must be longer than ' . self::MIN_LENGTH . ' characters');
        }

        if (strlen($plainPassword) > self::MAX_LENGTH) {
            throw new ApiInvalidArgumentException('Invalid password: cannot be longer than ' . self::MAX_LENGTH . ' characters');
        }

        $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => $cost]);

        return new self($passwordHash);
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function asString(): string
    {
        return $this->passwordHash;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->passwordHash);
    }
}
