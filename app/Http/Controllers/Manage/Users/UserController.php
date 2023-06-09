<?php

namespace App\Http\Controllers\Manage\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersManagerStoreRequest;
use App\Http\Requests\Users\UsersManagerUpdateRequest;
use App\Http\Requests\Users\UsersMemberStoreRequest;
use App\Http\Requests\Users\UsersMemberUpdateRequest;
use App\Interfaces\Users\UsersInterface;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UsersInterface $repository;
    public function __construct(UsersInterface $users)
    {
        $this->repository = $users;
    }

    public function managers_index()
    {
        return $this->repository->managers_index();
    }

    public function managers_store(UsersManagerStoreRequest $request)
    {
        return $this->repository->managers_store($request);
    }
    public function managers_update(Admin $admin,UsersManagerUpdateRequest $request)
    {
        return $this->repository->managers_update($request,$admin);
    }

    public function managers_delete(Admin $admin)
    {
        return $this->repository->managers_delete($admin);
    }




    public function members_index()
    {
        return $this->repository->members_index();
    }

    public function members_store(UsersMemberStoreRequest $request)
    {
        return $this->repository->members_store($request);
    }

    public function members_delete(User $user)
    {
        return $this->repository->members_delete($user);
    }

    public function members_update(User $user,UsersMemberUpdateRequest $request)
    {
        return $this->repository->members_update($request,$user);
    }

    public function members_activation(User $user)
    {
        return $this->repository->members_activation($user);

    }


}
