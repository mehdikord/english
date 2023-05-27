<?php
namespace App\Repository\Invoices;


use App\Interfaces\Invoices\InvoicesInterface;
use App\Models\Episode;
use App\Models\Invoice;
use App\Resources\Episodes\EpisodePublicResource;
use Illuminate\Support\Facades\Storage;

class InvoicesRepository implements InvoicesInterface
{
    public function index()
    {
        return response_success(Invoice::with('user')->OrderbyDesc('id')->get());
    }





}
