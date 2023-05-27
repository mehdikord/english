<?php

namespace App\Http\Controllers\Manage\Episodes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Episodes\EpisodesRequest;
use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    private EpisodesInterface $repository;
    public function __construct(EpisodesInterface $episodes)
    {
        $this->repository = $episodes;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function store(EpisodesRequest $request)
    {

        return $this->repository->store($request);
    }
    public function update(Episode $episode, EpisodesRequest $request)
    {
        return $this->repository->update($request,$episode);
    }

    public function delete(Episode $episode)
    {
        return $this->repository->delete($episode);
    }

    public function activation(Episode $episode)
    {
        return $this->repository->activation($episode);
    }

    public function download(Episode $episode)
    {
        return $this->repository->download($episode);
    }
}
