<?php
namespace App\Repository\Dashboard;


use App\Interfaces\Dashboard\DashboardInterface;
use App\Models\Admin;
use App\Models\Episode;
use App\Models\Invoice;
use App\Models\User;


class DashboardRepository implements DashboardInterface
{
    public function counts()
    {
        $data =[
            'admins' => Admin::count(),
            'users' => User::count(),
            'episodes' => Episode::count(),
        ];
        return response_success($data);
    }

    public function latest_users()
    {
        $data = User::OrderByDesc('id')->take(5)->get();
        return response_success($data);
    }

    public function latest_invoices()
    {
        $data = Invoice::with('user')->OrderByDesc('id')->take(5)->get();
        return response_success($data);
    }
}
