<?php

namespace Nebalus\Webapi\Api\Validator\User;

use Nebalus\Webapi\Api\Validator\AbstractValidator;
use Nebalus\Webapi\Value\User\Totp\TOTPCode;
use Nebalus\Webapi\Value\User\Username;
use Nebalus\Webapi\Value\User\UserPassword;

class UserAuthValidator extends AbstractValidator
{
    private Username $username;
    private UserPassword $userPassword;
    private bool $rememberMe;
    private ?TOTPCode $TOTPCode;

    public function __construct()
    {
        $rules = [
            'username' => [ 'required' => true, 'nullable' => false, 'datatype' => [ "string" ] ],
            'password' => [ 'required' => true, 'nullable' => false, 'datatype' => [ "string" ] ],
            'remember_me' => [ 'required' => false, 'nullable' => false, 'default' => false, 'datatype' => [ "boolean" ] ],
            'totp' => [ 'required' => false, 'nullable' => false, 'datatype' => [ "integer" ] ],
        ];
        parent::__construct($rules);
    }

    protected function onValidate(array $filteredData): void
    {
        $this->username = Username::from($filteredData['username']);
        $this->userPassword = UserPassword::fromPlain($filteredData['password']);
        $this->rememberMe = is_null($filteredData['remember_me']) ? null : $filteredData['remember_me'];
        $this->TOTPCode = is_null($filteredData['TOTP']) ? null : TOTPCode::from($filteredData['TOTP']);
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getPassword(): UserPassword
    {
        return $this->userPassword;
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
