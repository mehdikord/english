<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthUsersRegisterRequest;
use App\Interfaces\Auth\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthInterface $repository;
    public function __construct(AuthInterface $auth)
    {
        $this->repository = $auth;
    }

    public function login(AuthLoginRequest $request)
    {
        return $this->repository->user_login($request);
    }

    public function register(AuthUsersRegisterRequest $request)
    {
        return $this->repository->user_register($request);
    }
}
