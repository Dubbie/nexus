<?php

namespace App\Http\Responses;

use JsonSerializable;

class ApiResponse implements JsonSerializable
{
    public bool $success;
    public string $message;
    public mixed $data;

    public function __construct(bool $success, string $message, mixed $data)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return array_filter([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ], fn($value) => $value !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
