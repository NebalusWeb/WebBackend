<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\Module\Referral\ReferralCode;
use Nebalus\Webapi\Value\Module\Referral\ReferralLabel;
use Nebalus\Webapi\Value\Url;
use Nebalus\Webapi\Value\User\UserId;

class EditReferralValidator extends AbstractValidator
{
    private UserId $userId;
    private ReferralCode $code;
    private Url $url;
    private ReferralLabel $label;
    private bool $disabled;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "user_id" => UserId::getSchema(),
                'code' => ReferralCode::getSchema()
            ]),
            RequestParamTypes::BODY => S::object([
                'url' => Url::getSchema(),
                'label' => ReferralLabel::getSchema(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ApiException
     */
    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->userId = UserId::from($pathArgsData["user_id"]);
        $this->code = ReferralCode::from($pathArgsData['code']);
        $this->url = Url::from($bodyData['url']);
        $this->label = ReferralLabel::from($bodyData['label']);
        $this->disabled = $bodyData['disabled'];
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCode(): ReferralCode
    {
        return $this->code;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getLabel(): ReferralLabel
    {
        return $this->label;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
