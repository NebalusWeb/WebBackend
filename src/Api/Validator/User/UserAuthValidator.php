<?php

namespace Nebalus\Webapi\Api\Validator\User;

use Nebalus\Webapi\Api\Validator\AbstractValidator;
use Nebalus\Webapi\Value\User\Totp\TOTPCode;
use Nebalus\Webapi\Value\User\Username;

class UserAuthValidator extends AbstractValidator
{
    private Username $username;
    private string $password;
    private bool $rememberMe;
    private ?TOTPCode $TOTPCode;

    public function __construct()
    {
        $rules = [
            'username' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
            'password' => [ 'required' => true, 'nullable' => false, 'type' => "string" ],
            'remember_me' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => "boolean" ],
            'totp' => [ 'required' => false, 'nullable' => true, 'type' => "integer" ],
        ];
        parent::__construct($rules);
    }

    protected function onValidate(array $filteredData): void
    {
        $this->username = Username::from($filteredData['username']);
        $this->password = $filteredData['password'];
        $this->rememberMe = $filteredData['remember_me'];
        $this->TOTPCode = is_null($filteredData['totp']) ? null : TOTPCode::from($filteredData['totp']);
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberMe(): bool
    {
        return $this->rememberMe;
    }

    public function getTOTPCode(): ?TOTPCode
    {
        return $this->TOTPCode;
    }
}
