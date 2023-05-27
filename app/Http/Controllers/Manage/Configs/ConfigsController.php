<?php

namespace App\Http\Controllers\Manage\Configs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configs\ConfigsRequest;
use App\Interfaces\Configs\ConfigsInterface;
use App\Models\Config;
use App\Repository\Configs\ConfigsRepository;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    protected ConfigsInterface $repository;
    public function __construct(ConfigsRepository $configsRepository)
    {
        $this->repository = $configsRepository;

    }

    public function index()
    {
        return $this->repository->index();

    }

    public function update(ConfigsRequest $request,Config $config)
    {
        return $this->repository->update($request,$config);
    }

    public function default()
    {
        return $this->repository->default();
    }
}
