<?php

namespace Nebalus\Webapi\Api\User\Auth;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Utils\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
use Nebalus\Webapi\Value\Internal\Validation\ValidType;
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
        $schema = S::object([
            "body" => S::object([
                'username' => S::string()->required()->nullable(false),
                'password' => S::string()->required()->nullable(false),
                'remember_me' => S::boolean()->required(false)->nullable(false)->default(false),
                'totp' => S::integer()->required(false)->nullable(true),
            ])
        ]);
        $rules = [
            'body' => [
                'username' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
                'password' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
                'remember_me' => [ 'required' => false, 'nullable' => false, 'default' => false, 'type' => ValidType::BOOLEAN ],
                'totp' => [ 'required' => false, 'nullable' => true, 'type' => ValidType::INTEGER ],
            ]
        ];
        parent::__construct($rules);
    }

    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->username = Username::from($validatedData->getBodyData()['username']);
        $this->password = $validatedData->getBodyData()['password'];
        $this->rememberMe = $validatedData->getBodyData()['remember_me'];
        $this->TOTPCode = is_null($validatedData->getBodyData()['totp']) ? null : TOTPCode::from($validatedData->getBodyData()['totp']);
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
