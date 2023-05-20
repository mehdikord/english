<?php

//make auth sms
function helpers_auth_make($phone): void
{
    if (env('APP_DEBUG')){
        $code = 123456;
    }else{
        $code = random_int(100000,999999);
    }
    \App\Models\Auth::updateorcreate([
        'phone' => $phone],[
        'code' => $code,
        'updated_at' => \Carbon\Carbon::now(),
    ]);
}

//check auth sms time
function helpers_check_auth_sms_time($phone): bool
{
    $auth_code = \App\Models\Auth::where('phone',$phone)->first();
    if (!empty($auth_code)){
        $now_time = \Carbon\Carbon::now();
        return !($now_time->diffInMinutes($auth_code->updated_at) >= 2);
    }
    return false;
}

//check auth code
function helpers_check_auth_code($phone,$code){
    return \App\Models\Auth::where('phone',$phone)->where('code',$code)->exists();
}

function helpers_remove_auth_code($phone): void
{
    App\Models\Auth::where('phone',$phone)->delete();
}

//random code generator
function helpers_random_code($unique = 1,$count = 10): string
{
    $length = $count - strlen($unique) ;
    $start =1;
    $end = 9;
    for($i=1;$i<$length;$i++){
        $start.=0;
        $end.=9;
    }
    return $unique.rand($start,$end);
}
