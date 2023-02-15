<?php

namespace App\Services;

class ShoppingResponse
{
    private string $status;
    private ?string $message;
    private int $code;

    public function __construct(string $status, int $code, ?string $message = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->code = $code;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
