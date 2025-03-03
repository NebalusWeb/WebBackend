<?php

namespace Nebalus\Webapi\Api\User\Register;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Account\InvitationToken\InvitationTokenField;
use Nebalus\Webapi\Value\Account\InvitationToken\PureInvitationToken;
use Nebalus\Webapi\Value\User\UserEmail;
use Nebalus\Webapi\Value\User\Username;
use Nebalus\Webapi\Value\User\UserPassword;

class RegisterUserValidator extends AbstractValidator
{
    private PureInvitationToken $pureInvitationToken;
    private UserEmail $userEmail;
    private Username $username;
    private UserPassword $userPassword;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => S::object([
                'invitation_token' => S::object([
                    "field_1" => S::number()->integer()->gte(0)->lte(9999),
                    "field_2" => S::number()->integer()->gte(0)->lte(9999),
                    "field_3" => S::number()->integer()->gte(0)->lte(9999),
                    "field_4" => S::number()->integer()->gte(0)->lte(9999),
                    "checksum" => S::number()->integer()->gte(0)->lte(9999),
                ]),
                'email' => S::string()->email(),
                'username' => S::string(),
                'password' => S::string(),
            ])
        ]));
    }

    /**
     * @throws ApiException
     */
    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->pureInvitationToken = PureInvitationToken::from(
            InvitationTokenField::from($bodyData["invitation_token"]["field_1"]),
            InvitationTokenField::from($bodyData["invitation_token"]["field_2"]),
            InvitationTokenField::from($bodyData["invitation_token"]["field_3"]),
            InvitationTokenField::from($bodyData["invitation_token"]["field_4"]),
            InvitationTokenField::from($bodyData["invitation_token"]["checksum"])
        );
        $this->userEmail = UserEmail::from($bodyData["email"]);
        $this->username = UserName::from($bodyData["username"]);
        $this->userPassword = UserPassword::fromPlain($bodyData["password"]);
    }

    public function getPureInvitationToken(): PureInvitationToken
    {
        return $this->pureInvitationToken;
    }

    public function getUserEmail(): UserEmail
    {
        return $this->userEmail;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getUserPassword(): UserPassword
    {
        return $this->userPassword;
    }
}
