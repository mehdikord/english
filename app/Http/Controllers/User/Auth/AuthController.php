<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthUserSmsCheckRequest;
use App\Http\Requests\Auth\AuthUserSmsLoginRequest;
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

    public function sms_login(AuthUserSmsLoginRequest $request)
    {
        return $this->repository->user_sms_login($request);
    }

    public function sms_check(AuthUserSmsCheckRequest $request)
    {
        return $this->repository->user_sms_check($request);
    }
}
