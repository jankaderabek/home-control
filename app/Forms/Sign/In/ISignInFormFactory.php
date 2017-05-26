<?php declare(strict_types = 1);

namespace App\Forms\User;

interface ISignInFormFactory
{
    public function create(): SignInForm;
}