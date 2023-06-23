<?php

namespace App\Http\Controllers\Manage\Packs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packs\PacksRequest;
use App\Models\Life_Pack;
use App\Repository\Life\LifeRepository;
use Illuminate\Http\Request;

class PackController extends Controller
{
    private LifeRepository $repository;
    public function __construct(LifeRepository $lifeRepository)
    {
        $this->repository = $lifeRepository;
    }
    public function index()
    {
        return $this->repository->pack_index();
    }
    public function store(PacksRequest $request)
    {
        return $this->repository->pack_store($request);
    }
    public function update(Life_Pack $pack, PacksRequest $request)
    {
        return $this->repository->pack_update($request,$pack);
    }
    public function delete(Life_Pack $pack)
    {
        return $this->repository->pack_delete($pack);
    }



}
