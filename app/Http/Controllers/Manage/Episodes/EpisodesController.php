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
    public function update(Episode $faq, EpisodesRequest $request)
    {
        return $this->repository->update($request,$faq);
    }

    public function delete(Episode $faq)
    {
        return $this->repository->delete($faq);
    }
}
