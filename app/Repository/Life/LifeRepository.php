<?php
namespace App\Repository\Life;


use App\Interfaces\Life\LifeInterface;
use App\Models\Faq;

class LifeRepository implements LifeInterface
{
    public function index()
    {
        return response_success(auth('users')->user()->life);
    }



}
