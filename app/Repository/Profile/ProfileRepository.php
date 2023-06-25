<?php
namespace App\Repository\Profile;



use App\Interfaces\Profile\ProfileInterface;

class ProfileRepository implements ProfileInterface
{
    public function manage_me()
    {
        return response_success(auth('admin')->user(),'management profile');
    }

    public function user_me()
    {
        return response_success(auth('users')->user());
    }

    public function user_update($request)
    {
        auth('users')->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response_success(auth('users')->user());
    }

    public function user_update_level($request)
    {
        auth('users')->user()->update([
            'level' => $request->level,
        ]);
        return response_success(auth('users')->user());
    }



}
