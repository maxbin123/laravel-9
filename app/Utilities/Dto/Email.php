<?php

namespace App\Utilities\Dto;

class Email
{

    public function __construct(
        public string $email,
        public string $subject,
        public string $body
    )
    {}
}
