<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\User;

use InvalidArgumentException;
use function strlen;

readonly class UserHashedPassword
{
    private function __construct(
        private string $hashedPassword
    ) {
    }

    public static function from(string $plainPassword, string $passwordHashKey): self
    {
        if (strlen($plainPassword) < 8) {
            throw new InvalidArgumentException('Invalid password: must be longer than 8 characters');
        }

        if (strlen($plainPassword) > 20) {
            throw new InvalidArgumentException('Invalid password: cannot be longer than 20 characters');
        }

        $passwordHash = hash_hmac('sha256', $plainPassword, $passwordHashKey);

        return new self($passwordHash);
    }

    public static function fromHashedPassword(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function asString(): string
    {
        return $this->hashedPassword;
    }
}
