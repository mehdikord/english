<?php
/*
 * Payment gateway config
 *
 *
 */
return [

    "zarinpal_merchant" => env('ZARINPAL_MERCHANT','test'),
    "zarinpal_sandbox" => env("ZARINPAL_SANDBOX",true),
    "zarinpal_gate" => env("ZARINPAL_SANDBOX",false),


];
