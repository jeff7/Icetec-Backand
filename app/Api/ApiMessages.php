<?php

namespace App\Api;

class ApiMessages
{
    private $message = [];

    public function __construct(string $message, array $data = [])
    {
        # code...
        $this->message['message'] = $message;
        $this->message['errors'] = $data;
    }

    public function getMessage()
    {
        # code...
        return $this->message;
    }
}