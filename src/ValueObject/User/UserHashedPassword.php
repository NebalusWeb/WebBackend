<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\User;

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
        if (strlen($plainPassword) > 20) {
            throw new InvalidArgumentException('Invalid password: cannot be longer than 20 characters');
        }

        $passwordRegEx = '/^(?=(.*[A-Z]){2,})(?=(.*\d){2,})(?=(.*[a-z]){3,})(?=.*[!@#$&*?]).{8,}$/';

        if (preg_match($passwordRegEx, $plainPassword) < 1) {
            throw new InvalidArgumentException(
                'Invalid password: must contain at least 2 uppercase and 3 lowercase letters, 2 numbers,' .
                ' 1 special character(!@#$&*?) and be at least 8 characters long'
            );
        }

        $passwordHash = hash_hmac('sha256', $plainPassword, $passwordHashKey);

        return new self($passwordHash);
    }

    public static function fromHashedPassword(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
