<?php

namespace App\Http\Controllers\Manage\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Dashboard\DashboardInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardInterface $repository;
    public function __construct(DashboardInterface $dashboard)
    {
        return $this->repository = $dashboard;
    }

    public function counts()
    {
        return $this->repository->counts();
    }

    public function latest_users()
    {
        return $this->repository->latest_users();
    }

    public function latest_invoices()
    {
        return $this->repository->latest_invoices();
    }

}
