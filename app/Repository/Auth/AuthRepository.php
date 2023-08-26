<?php
namespace App\Repository\Auth;

use App\Interfaces\Auth\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthInterface
{
    public function manage_login($request)
    {

        $credentials = request(['email', 'password']);
        if (! $token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function manage_logout()
    {

    }

    public function user_register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $token = auth('users')->login($user);
        return response()->json($this->respondWithTokenUsers($token));

    }

    public function user_login($request)
    {

        $credentials = request(['email', 'password']);
        if (! $token = auth('users')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithTokenUsers($token);
    }

    public function user_logout()
    {

    }

    public function user_sms_login($request)
    {

        if (helpers_check_auth_sms_time($request->phone)){
            return response_custom_error("The previously sent message is valid for two minutes!");
        }
        $user = User::where('phone',$request->phone)->first();
        if (empty($user)){
            $user = User::create([
                'name' => 'user_'.rand(1000,9999),
                'phone' => $request->phone,
                'life' => 10,
            ]);
        }
        helpers_auth_make($request->phone);
        return response_success(['phone' => $request->phone],'The authentication SMS was sent successfully');
    }

    public function user_sms_check($request)
    {

        if (helpers_check_auth_code($request->phone,$request->code)){
            if (!helpers_check_auth_sms_time($request->phone)){
                return response_custom_error("The time to send the message has expired");
            }
            $user = User::where('phone',$request->phone)->first();
            $token =  auth('users')->login($user);
            helpers_remove_auth_code($request->phone);
            return $this->respondWithTokenUsers($token);
        }
        return response_custom_error("The code is incorrect");

    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('admin')->user(),
        ]);
    }

    protected function respondWithTokenUsers($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('users')->user(),
        ]);
    }



}
