<?php

namespace App\Http\Controllers\User\Life;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\BuyLifeRequest;
use App\Interfaces\Life\LifeInterface;
use App\Models\Life_Pack;
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

    public function buy(BuyLifeRequest $request)
    {
        return $this->repository->buy($request);
    }

    public function delete()
    {

        return $this->repository->delete();
    }

    public function pack_index()
    {
        return $this->repository->pack_user_index();
    }

    public function pack_buy(Life_Pack $pack)
    {
        return $this->repository->pack_user_by($pack);
    }

    public function change(BuyLifeRequest $request)
    {
        return $this->repository->change($request);
    }
}
