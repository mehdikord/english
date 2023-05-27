<?php

namespace App\Http\Controllers\User\Episodes;

use App\Http\Controllers\Controller;
use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    private EpisodesInterface $repository;
    public function __construct(EpisodesInterface $episodes)
    {
        $this->repository = $episodes;
    }
    public function index()
    {
        return $this->repository->user_index();
    }

    public function active()
    {
        return $this->repository->user_active();
    }

    public function buy(Episode $episode)
    {
        return $this->repository->user_buy($episode);
    }
}
