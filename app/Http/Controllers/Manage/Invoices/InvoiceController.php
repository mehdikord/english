<?php

namespace App\Http\Controllers\Manage\Invoices;

use App\Http\Controllers\Controller;
use App\Interfaces\Invoices\InvoicesInterface;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private InvoicesInterface $repository;
    public function __construct(InvoicesInterface $invoices)
    {
        $this->repository = $invoices;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function change_payment(Invoice $invoice)
    {
        return $this->repository->change_payment($invoice);

    }

}
