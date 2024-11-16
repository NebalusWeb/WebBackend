<?php

namespace Nebalus\Webapi\Api\Validator\Referral;

use Nebalus\Webapi\Api\Validator\AbstractValidator;

class ReferralCreateValidator extends AbstractValidator
{
}

//<?php
//
//use Exception;
//
//class EditUserValidator extends AbstractValidator
//{
//    private ?UserEditedFields $userEditedFields;
//
//    public function __construct(
//        private readonly MySqlUserRepository $mysqlUserRepository,
//        private readonly EnvData $envData
//    ) {
//        parent::__construct();
//    }
//
//    /**
//     * @throws Exception
//     */
//public function isFilteredInputValid(array $filteredInput): bool
//{
//    try {
//        $userId = UserId::from($filteredInput['userId']);
//
//        $existingUser = $this->mysqlUserRepository->getUserByUserId($userId);
//        if ($existingUser === null) {
//            $this->errorMessage = 'User does not exist.';
//            return false;
//        }
//
//        $username = null;
//        if (isset($filteredInput['username'])) {
//            $username = Username::from($filteredInput['username']);
//            $usernameAsString = $username->asString();
//
//            $existingUser = $this->mysqlUserRepository->getUserByUsername($username);
//            if ($existingUser instanceof User && $userId->asInt() !== $existingUser->getUserId()?->asInt()) {
//                $this->errorMessage = "Another user is already registered with the username '$usernameAsString'.";
//                return false;
//            }
//        }
//
//        $hashedPassword = null;
//        if (isset($filteredInput['password'])) {
//            $hashedPassword = UserHashedPassword::from($filteredInput['password'], $this->envData->getPasswdHashKey());
//        }
//
//        $userDescription = null;
//        if (isset($filteredInput['description'])) {
//            $userDescription = UserDescription::from($filteredInput['description']);
//        }
//
//        $this->userEditedFields = UserEditedFields::from(
//            $userId,
//            $username,
//            $hashedPassword,
//            $userDescription,
//            $filteredInput['isAdmin'],
//            $filteredInput['isEnabled']
//        );
//        return true;
//    } catch (InvalidArgumentException $e) {
//        $this->errorMessage = $e->getMessage();
//        return false;
//    }
//}
//
//public function getUserEditedFields(): UserEditedFields
//{
//    return $this->userEditedFields;
//}
//}
//
