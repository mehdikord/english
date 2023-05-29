<?php

namespace App\Http\Controllers\User\Episodes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Episodes\EpisodesSetLevelRequest;
use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use App\Models\User_Episode;
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

    public function set_active(User_Episode $episode)
    {
        return $this->repository->user_set_active($episode);

    }

    public function set_done(User_Episode $episode)
    {
        return $this->repository->user_set_done($episode);

    }

    public function set_level(EpisodesSetLevelRequest $request,User_Episode $episode)
    {

        return $this->repository->user_set_level($episode,$request);
    }
}
