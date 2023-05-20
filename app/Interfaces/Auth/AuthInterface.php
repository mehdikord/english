<?php
namespace App\Interfaces\Auth;

interface AuthInterface
{

    //Management
    public function manage_login($request);
    public function manage_logout();

    public function user_register($request);
    public function user_login($request);
    public function user_logout();

    public function user_sms_login($request);

    public function user_sms_check($request);

}
