<?php

namespace Nebalus\Webapi\Api\Validator\User;

use Nebalus\Webapi\Api\Validator\AbstractValidator;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\InvitationToken\PureInvitationToken;
use Nebalus\Webapi\Value\User\UserEmail;
use Nebalus\Webapi\Value\User\Username;
use Nebalus\Webapi\Value\User\UserPassword;

class UserRegisterValidator extends AbstractValidator
{
    private PureInvitationToken $pureInvitationToken;
    private UserEmail $userEmail;
    private Username $username;
    private UserPassword $userPassword;

    public function __construct()
    {
        $rules = [
            'invitation_token' => [
                'required' => true,
                'nullable' => false,
                'datatype' => "object",
                'children' => [
                    "field_1" => [ 'required' => true, 'nullable' => false, 'datatype' => "integer" ],
                    "field_2" => [ 'required' => true, 'nullable' => false, 'datatype' => "integer" ],
                    "field_3" => [ 'required' => true, 'nullable' => false, 'datatype' => "integer" ],
                    "field_4" => [ 'required' => true, 'nullable' => false, 'datatype' => "integer" ],
                    "checksum" => [ 'required' => true, 'nullable' => false, 'datatype' => "integer" ],
                ]
            ],
            'email' => [ 'required' => true, 'nullable' => false, 'datatype' => "string" ],
            'username' => [ 'required' => true, 'nullable' => false, 'datatype' => "string" ],
            'password' => [ 'required' => true, 'nullable' => false, 'datatype' => "string" ],
        ];
        parent::__construct($rules);
    }

    /**
     * @throws ApiException
     */
    protected function onValidate(array $filteredData): void
    {
        $this->pureInvitationToken = PureInvitationToken::from(
            $filteredData["invitation_token"]["field_1"],
            $filteredData["invitation_token"]["field_2"],
            $filteredData["invitation_token"]["field_3"],
            $filteredData["invitation_token"]["field_4"],
            $filteredData["invitation_token"]["checksum"]
        );
        $this->userEmail = UserEmail::from($filteredData["email"]);
        $this->username = UserName::from($filteredData["username"]);
        $this->userPassword = UserPassword::fromPlain($filteredData["password"]);
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
