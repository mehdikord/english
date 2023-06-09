<?php

namespace App\Http\Controllers\Public\Episodes;

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
        return $this->repository->public_index();
    }

    public function download(Episode $episode)
    {
        return $this->repository->download($episode);
    }


}
