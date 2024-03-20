<?php

namespace Nebalus\Webapi\ValueObjects;

class HttpBodyJsonResponse
{
    // -1 = error
    // 0 = success
    // 1 = fail
    private int $status;
    private array $data;
    private string $errorMessage;

    public function __construct()
    {
        $this->status = 0;
        $this->data = [];
        $this->errorMessage = "Unknown Error!";
    }

    public function setStatus(int $value): void
    {
        $this->status = $value;
    }

    public function setData(array $values): void
    {
        $this->data = $values;
    }

    public function setErrorMessage(string $value): void
    {
        $this->errorMessage = $value;
    }

    public function format(): string
    {
        $responseArray = [];

        if ($this->status <= -1) {
            $responseArray["status"] = "error";
            $responseArray["message"] = $this->errorMessage;
        } elseif ($this->status === 0) {
            $responseArray["status"] = "success";
            $responseArray["data"] = $this->data;
        } elseif ($this->status >= 1) {
            $responseArray["status"] = "fail";
            $responseArray["data"] = $this->data;
        }

        return json_encode($responseArray);
    }
}
