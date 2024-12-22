<?php

namespace Nebalus\Webapi\Api\User\Register;

use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Account\InvitationToken\InvitationTokenField;
use Nebalus\Webapi\Value\Account\InvitationToken\PureInvitationToken;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
use Nebalus\Webapi\Value\Internal\Validation\ValidType;
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
        $rules = [
            'body' => [
                'invitation_token' => [
                    'required' => true,
                    'nullable' => false,
                    'type' => ValidType::OBJECT,
                    'children' => [
                        "field_1" => [ 'required' => true, 'nullable' => false, 'type' => ValidType::INTEGER ],
                        "field_2" => [ 'required' => true, 'nullable' => false, 'type' => ValidType::INTEGER ],
                        "field_3" => [ 'required' => true, 'nullable' => false, 'type' => ValidType::INTEGER ],
                        "field_4" => [ 'required' => true, 'nullable' => false, 'type' => ValidType::INTEGER ],
                        "checksum" => [ 'required' => true, 'nullable' => false, 'type' => ValidType::INTEGER ],
                    ]
                ],
                'email' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
                'username' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
                'password' => [ 'required' => true, 'nullable' => false, 'type' => ValidType::STRING ],
            ]
        ];
        parent::__construct($rules);
    }

    /**
     * @throws ApiException
     */
    protected function onValidate(ValidatedData $validatedData): void
    {
        $this->pureInvitationToken = PureInvitationToken::from(
            InvitationTokenField::from($validatedData->getBodyData()["invitation_token"]["field_1"]),
            InvitationTokenField::from($validatedData->getBodyData()["invitation_token"]["field_2"]),
            InvitationTokenField::from($validatedData->getBodyData()["invitation_token"]["field_3"]),
            InvitationTokenField::from($validatedData->getBodyData()["invitation_token"]["field_4"]),
            InvitationTokenField::from($validatedData->getBodyData()["invitation_token"]["checksum"])
        );
        $this->userEmail = UserEmail::from($validatedData->getBodyData()["email"]);
        $this->username = UserName::from($validatedData->getBodyData()["username"]);
        $this->userPassword = UserPassword::fromPlain($validatedData->getBodyData()["password"]);
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
