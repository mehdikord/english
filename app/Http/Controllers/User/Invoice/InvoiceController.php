<?php

namespace App\Http\Controllers\User\Invoice;

use App\Http\Controllers\Controller;
use App\Interfaces\Episodes\EpisodesInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private EpisodesInterface $repository;
    public function __construct(EpisodesInterface $episodes)
    {
        $this->repository = $episodes;
    }
    public function callback_zarinpal()
    {


    }
}
