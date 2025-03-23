<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\Module\Referral\ReferralLabel;
use Nebalus\Webapi\Value\Url;

class CreateReferralValidator extends AbstractValidator
{
    private ReferralLabel $label;
    private Url $url;
    private bool $disabled;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => S::object([
                'label' => S::string(),
                'url' => S::string()->url(),
                'disabled' => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->label = ReferralLabel::from($bodyData['label']);
        $this->url = Url::from($bodyData['url']);
        $this->disabled = $bodyData['disabled'];
    }

    public function getLabel(): ReferralLabel
    {
        return $this->label;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
