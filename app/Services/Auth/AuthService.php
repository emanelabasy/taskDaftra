<?php
namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;

class AuthService
{
    public function __construct(
        protected AuthRepository  $authRepository   
    ){
    }

    public function login($input)
    {
        return $this->authRepository->login($input);
    }

}