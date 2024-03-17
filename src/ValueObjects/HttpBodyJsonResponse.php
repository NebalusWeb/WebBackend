<?php

namespace Nebalus\Webapi\ValueObjects;

class HttpBodyJsonResponse
{
    private bool $success;
    private int $statusCode;
    private array $payload;
    private array $error;

    public function __construct()
    {
        $this->success = false;
        $this->statusCode = 400;
        $this->payload = [];
        $this->error = [
            "code" => 0,
            "message" => "Unknown Error!"
        ];
    }

    public function setSuccess(bool $value)
    {
        $this->success = $value;
    }

    public function setStatusCode(int $value)
    {
        $this->statusCode = $value;
    }

    public function setErrorCode(int $value)
    {
        $this->error["code"] = $value;
    }

    public function setErrorMessage(string $value)
    {
        $this->error["message"] = $value;
    }

    public function format(): string
    {
        $responseArray = [
            "success" => $this->success,
            "status_code" => $this->statusCode
        ];

        if ($this->success) {
            $responseArray["payload"] = $this->payload;
        } else {
            $responseArray["error"] = $this->error;
        }

        return json_encode($responseArray);
    }
}
