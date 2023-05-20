<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUserUpdateRequest;
use App\Interfaces\Profile\ProfileInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private ProfileInterface $repository;
    public function __construct(ProfileInterface $profile)
    {
        $this->repository = $profile;
    }

    public function me()
    {
        return $this->repository->user_me();
    }

    public function update(ProfileUserUpdateRequest $request)
    {
        return $this->repository->user_update($request);
    }
}
