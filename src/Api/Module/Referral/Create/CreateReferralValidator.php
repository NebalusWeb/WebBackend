<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Exception\ApiException;
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
                'label' => ReferralLabel::getSchema(),
                'url' => Url::getSchema(),
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
