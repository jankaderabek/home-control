<?php declare(strict_types = 1);

namespace App\Forms\Sign\In;

interface ISignInFormFactory
{
    public function create(): SignInForm;
}