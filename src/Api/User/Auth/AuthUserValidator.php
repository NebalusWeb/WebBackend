<?php

namespace Nebalus\Webapi\Api\User\Auth;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\Totp\TOTPCode;
use Nebalus\Webapi\Value\User\Username;

class AuthUserValidator extends AbstractValidator
{
    private Username $username;
    private string $password;
    private bool $rememberMe;
    private ?TOTPCode $TOTPCode;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => S::object([
                'username' => S::string(),
                'password' => S::string(),
                'remember_me' => S::boolean()->optional()->default(false),
                'totp' => S::string()->optional()->nullable(),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->username = Username::from($bodyData['username']);
        $this->password = $bodyData['password'];
        $this->rememberMe = $bodyData['remember_me'];
        $this->TOTPCode = is_null($bodyData['totp']) ? null : TOTPCode::from($bodyData['totp']);
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
