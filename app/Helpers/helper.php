<?php
use Kavenegar\Laravel\Facade as Kavenegar;



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
//    if (env('APP_DEBUG')){
        $req = new \GuzzleHttp\Client();
        $req->get("https://api.kavenegar.com/v1/35573978332F642B394559316A4A59574D71776A5033344D754846616437523950486A6E33326B673367383D/verify/lookup.json?receptor=$phone&token=$code&template=attivaa-auth");
//    }

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

//get system config
function helper_config($key){
    $conf = \App\Models\Config::where('conf_key',$key)->first();
    return $conf->conf_val ?? '';
}
