<?php
namespace App\Repository\Life;


use App\Interfaces\Life\LifeInterface;
use App\Models\Faq;
use App\Models\Invoice;
use App\Models\Life_Pack;
use App\Services\Zarinpal\ZarinpalService;
use Illuminate\Support\Facades\DB;

class LifeRepository implements LifeInterface
{

    public $zarinpal_service;
    public function __construct()
    {
        $this->zarinpal_service = new ZarinpalService();

    }
    public function index()
    {
        return response_success(auth('users')->user()->life);
    }

    public function delete()
    {
        $user = auth('users')->user();
        if ($user->life > 0){
            $user->update(['life' => $user->life - 1 ]);
        }
        return response_success('','life removed success');
    }

    public function buy($request)
    {
        $amount=null;
        if (helper_config('life_price')){
            $amount = $request->total * helper_config('life_price');
        }
        if (!$amount){
            return response_custom_error("Something in wrong.please contact admins");
        }

        DB::beginTransaction();
        $invoice = Invoice::create([
            'user_id' => auth('users')->id(),
            'title' => "Buy Life : $request->total",
            'method' => 'online',
            'life' =>$request->total,
            'price' => $amount,
            'gateway'=>"Zarinpal",
        ]);
        $invoice->update(['code' => helpers_random_code($invoice->id,13)]);
        //start payment request

        $callback = url('api/users/payments/zarinpal_callback');
        $pay = $this->zarinpal_service->
        request(
            $amount,
            $invoice->code,
            $callback,
            auth('users')->user()->phone,
            auth('users')->user()->email,
            $invoice->title,
        );
        if ($pay && $pay['Status'] == 100){
            $invoice->update(['gateway_code' => $pay['Authority'] ]);
            DB::commit();
            return response_success($pay['StartPay'],'payment link');
        }else{
            DB::rollBack();
            return response_custom_error('There is a problem with the payment process. Please contact the management ');
        }



    }

    public function pack_index()
    {
        return response_success(Life_Pack::withCount('invoices')->OrderbyDesc('id')->get());
    }

    public function pack_store($request)
    {
        $item = Life_Pack::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'life' => $request->life,
            'price' => $request->price,
        ]);
        return response_success($item);
    }

    public function pack_update($request,$item)
    {
        $item->update([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'life' => $request->life,
            'price' => $request->price,
        ]);
        return response_success($item);
    }

    public function pack_delete($item)
    {
        $item->delete();
        return response_success(true,'item deleted success');
    }

    public function pack_user_index()
    {
        return response_success(Life_Pack::all());
    }

    public function pack_user_by($item)
    {
        $amount=$item->price;
        if (!$amount){
            return response_custom_error("Something in wrong.please contact admins");
        }

        DB::beginTransaction();
        $invoice = Invoice::create([
            'user_id' => auth('users')->id(),
            'life_pack_id' => $item->id,
            'title' => "Buy Life Pack : $item->name",
            'method' => 'online',
            'price' => $amount,
            'gateway'=>"Zarinpal",
        ]);
        $invoice->update(['code' => helpers_random_code($invoice->id,13)]);
        //start payment request

        $callback = url('api/users/payments/zarinpal_callback');
        $pay = $this->zarinpal_service->
        request(
            $amount,
            $invoice->code,
            $callback,
            auth('users')->user()->phone,
            auth('users')->user()->email,
            $invoice->title,
        );
        if ($pay && $pay['Status'] == 100){
            $invoice->update(['gateway_code' => $pay['Authority'] ]);
            DB::commit();
            return response_success($pay['StartPay'],'payment link');
        }else{
            DB::rollBack();
            return response_custom_error('There is a problem with the payment process. Please contact the management ');
        }


    }

    public function change($request)
    {
        auth('users')->user()->update(['life' => $request->total]);
        return response_success([],'Life changed success');

    }



}
