<?php declare(strict_types = 1);

namespace App\Forms\Sign\Up;

interface ISignUpFormFactory
{
    public function create(): SignUpForm;
}