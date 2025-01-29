<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Value\Internal\Validation\ValidRequestData;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractValidator
{
    public const int MAX_RECURSION = 100;

    protected function __construct(private readonly array $rules = [])
    {
    }

    /**
     * @throws ApiException
     */
    public function validate(ServerRequestInterface $request, array $rawPathArgs = []): void
    {
        $schema = Sanitizr::object($this->rules);
        $validData = $schema->safeParse([
            'body' => json_decode($request->getBody()->getContents(), true, self::MAX_RECURSION) ?? [],
            'query_params' => $request->getQueryParams() ?? [],
            'path_args' => $rawPathArgs,
        ]);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException($validData->getErrorMessage());
        }

        $validatedData = ValidRequestData::from($validData->getValue()["body"] ?? [], $validData->getValue()["query_params"] ?? [], $validData->getValue()["path_args"] ?? []);
        $this->onValidate($validatedData);
    }

    /**
     * @throws ApiException
     */
    abstract protected function onValidate(ValidRequestData $request): void;
}
