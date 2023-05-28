<?php
namespace App\Interfaces\Invoices;

interface InvoicesInterface
{

    public function index();

    public function change_payment($item);


    public function zarinpal_callback();




}
