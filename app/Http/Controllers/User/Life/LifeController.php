<?php

namespace App\Http\Controllers\User\Life;

use App\Http\Controllers\Controller;
use App\Interfaces\Life\LifeInterface;
use Illuminate\Http\Request;

class LifeController extends Controller
{

    private LifeInterface $repository;
    public function __construct(LifeInterface $life)
    {
        $this->repository = $life;
    }

    public function index()
    {
        return $this->repository->index();
    }
}
