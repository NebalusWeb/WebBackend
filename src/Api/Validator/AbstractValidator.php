<?php

namespace Nebalus\Webapi\Api\Validator;

use JsonException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Exception\ApiValidationException;
use Psr\Http\Message\ServerRequestInterface;
use function PHPUnit\Framework\isType;

abstract class AbstractValidator
{
    private array $rules;

    protected function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @throws ApiException
     */
    public function validate(ServerRequestInterface $request): void
    {
        try {
            $data = json_decode($request->getBody()->getContents(), true, 5, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new ApiValidationException(
                'Invalid JSON request',
                400
            );
        }

        $filteredData = $this->processRecursiveRules($data, $this->rules, 5);
        echo json_encode($filteredData, JSON_PRETTY_PRINT, 5) . "\n\n";
        $this->onValidate($filteredData);
    }

    /**
     * @throws ApiException
     */
    private function processRecursiveRules(array $dataLayer, array $ruleLayer, int $maxRecursion, int $layerId = 0, string $path = ''): array
    {
        $processedData = [];
        $layerId++;
        if ($layerId > $maxRecursion) {
            return $processedData;
        }

        foreach ($ruleLayer as $param => $rule) {
            $currentPath = $path . $param;
            $isRequired = $rule['required'] ?? false;
            $isNullable = $rule['nullable'] ?? false;
            $defaultValue = $rule['default'] ?? null;
            $datatype = strtolower($rule['datatype']) ?? null;
            $childrenRules = $rule['children'] ?? [];
            echo("----------------------------------- \n");
            echo("LayerID: \n");
            var_dump($layerId);
            echo("CurrentPath: \n");
            var_dump($currentPath);
            echo("IsRequired: \n");
            var_dump($isRequired);
            echo("IsNullable: \n");
            var_dump($isNullable);
            echo("DefaultValue: \n");
            var_dump($defaultValue);
            echo("Datatype: \n");
            var_dump($datatype);
            echo(" \n");
            if ($isRequired && key_exists($param, $dataLayer) === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' is required in the JSON request",
                    400
                );
            }

            $value = $dataLayer[$param];

            if ($isNullable === false && is_null($value)) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' cannot be null",
                    400
                );
            }

            if ($isNullable && is_null($value)) {
                $value = $defaultValue;
            }

            if ($datatype === 'string' && is_string($value) === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' can't be casted to a string",
                    400
                );
            } elseif ($datatype === 'integer' && is_int($value) === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' can't be casted to a integer",
                    400
                );
            } elseif ($datatype === 'float' && is_float($value) === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' can't be casted to a float",
                    400
                );
            } elseif ($datatype === 'boolean' && is_bool($value) === false) {
                throw new ApiInvalidArgumentException(
                    "Parameter '{$currentPath}' can't be casted to a boolean",
                    400
                );
            } elseif ($datatype === 'object') {
                if ($childrenRules !== []) {
                    $value = $this->processRecursiveRules($dataLayer[$param], $childrenRules, $maxRecursion, $layerId, $currentPath . ".");
                }
            }
            $processedData[$param] = $value;
        }
        return $processedData;
    }

    /**
     * @throws ApiException
     */
    abstract protected function onValidate(array $filteredData): void;
}
