<?php

namespace Nebalus\Webapi\Api;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSchema;
use Nebalus\Webapi\Value\Internal\Validation\ValidatedData;
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
        if (isset($this->rules['body'])) {
            $rawBodyData = json_decode($request->getBody()->getContents(), true, self::MAX_RECURSION) ?? [];
            $validBodyData = $this->validateJsonSchema($this->rules['body'], $rawBodyData);
        }

        if (isset($this->rules['query_param'])) {
            $rawQueryParamData = $request->getQueryParams() ?? [];
            $validQueryParamData = $this->validateJsonSchema($this->rules['query_param'], $rawQueryParamData);
        }

        if (isset($this->rules['path_args'])) {
            $validPathArgsData = $this->validateJsonSchema($this->rules['path_args'], $rawPathArgs);
        }

        $validatedData = ValidatedData::from($validBodyData ?? [], $validQueryParamData ?? [], $validPathArgsData ?? []);
        $this->onValidate($validatedData);
    }

    /**
     * @throws ApiException
     */
    private function validateJsonSchema(AbstractSchema $schema, array $data): array
    {
        return $schema->parse($data) ?? [];
    }

    /**
     * @throws ApiException
     */
    abstract protected function onValidate(ValidatedData $validatedData): void;
}
