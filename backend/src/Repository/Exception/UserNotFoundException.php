<?php

namespace App\Repository\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct(string $message = "User not found.")
    {
        parent::__construct($message);
    }
}
