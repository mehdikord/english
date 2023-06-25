<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function version()
    {
        return response_success(Config::where('conf_key','version')->first());
    }
}
