<?php

namespace Nebalus\Webapi\Value;

readonly class ValidatedData
{
    private function __construct(
        private array $bodyData,
        private array $queryParamsData,
        private array $pathArgsData,
    ) {
    }

    public static function create(): self
    {
        return new self([], [], []);
    }

    public static function from(
        array $bodyData = [],
        array $queryParamsData = [],
        array $pathArgsData = []
    ): self {
        return new self($bodyData, $queryParamsData, $pathArgsData);
    }

    public function getBodyData(): array
    {
        return $this->bodyData;
    }

    public function getQueryParamsData(): array
    {
        return $this->queryParamsData;
    }

    public function getPathArgsData(): array
    {
        return $this->pathArgsData;
    }

    public function setBodyData(array $bodyData): self
    {
        return new self($bodyData, $this->queryParamsData, $this->pathArgsData);
    }

    public function setQueryParamsData(array $queryParamsData): self
    {
        return new self($this->bodyData, $queryParamsData, $this->pathArgsData);
    }

    public function setPathArgsData(array $pathArgsData): self
    {
        return new self($this->bodyData, $this->queryParamsData, $pathArgsData);
    }
}
