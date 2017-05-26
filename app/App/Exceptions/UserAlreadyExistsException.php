<?php

namespace App\Exceptions;


class UserAlreadyExistsException extends \RuntimeException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf("User with email %s already exists", $email));
    }
}