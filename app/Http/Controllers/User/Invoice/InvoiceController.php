<?php

namespace App\Http\Controllers\User\Invoice;

use App\Http\Controllers\Controller;
use App\Interfaces\Episodes\EpisodesInterface;
use App\Interfaces\Invoices\InvoicesInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private InvoicesInterface $repository;
    public function __construct(InvoicesInterface $invoices)
    {
        $this->repository = $invoices;
    }
    public function callback_zarinpal()
    {
        return $this->repository->zarinpal_callback();

    }
}
