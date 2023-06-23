<?php
namespace App\Repository\Invoices;


use App\Interfaces\Invoices\InvoicesInterface;
use App\Models\Episode;
use App\Models\Invoice;
use App\Resources\Episodes\EpisodePublicResource;
use App\Services\Zarinpal\ZarinpalService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesRepository implements InvoicesInterface
{
    public $zarinpal_service;
    public function __construct()
    {
        $this->zarinpal_service = new ZarinpalService();

    }
    public function index()
    {
        return response_success(Invoice::with('user')->OrderbyDesc('id')->get());
    }

    public function change_payment($item)
    {
        if ($item->is_pay){
            $item->update([
                'is_pay' => false,
                'paid_at'=>null,
            ]);
        }else{
            $item->update([
                'is_pay' => true,
                'paid_at'=>Carbon::now(),
            ]);
        }
        $item->load('user');
        return response_success($item);

    }


    public function zarinpal_callback()
    {
        //get token from url params
        $authority = request('Authority');
        //get invoice
        $invoice = Invoice::where('gateway_code',$authority)->first();
        DB::beginTransaction();
        if (!$invoice){
            DB::rollBack();
            return redirect()->route('reports_payment_failed')->with(['error' => 'invoice not found!']);
        }
        $result = $this->zarinpal_service->verify($invoice->price,$authority);

        if(isset($result['Status']) && $result['Status']==100){
            //check ref_id
            if ($result['Node'] != 'sandbox' && Invoice::where('ref_id',$result['RefID'])->exists()){
                DB::rollBack();
                return redirect()->route('reports_payment_failed',['error' => 'The transaction is repeated!']);
            }
            $invoice->update([
                'is_pay' =>true,
                'paid_at'=>Carbon::now(),
                'ref_id' => $result['RefID'],
            ]);
            $user = $invoice->user;
            if (!empty($invoice->episode)){
                if (Episode::where('id',$invoice->episode)->exists()){
                    $user->episodes()->updateOrCreate([
                        'episode_id' => $invoice->episode,
                    ],[
                        'status' => 'pending'
                    ]);
                }
            }
            if (!empty($invoice->life) && $invoice->life > 0) {
                $user->update(['life' => $user->life + $invoice->life]);
            }
            if (!empty($invoice->life_pack_id) && !empty($invoice->pack)){
                $pack_life = $invoice->pack->life;
                $user->update(['life' => $user->life + $pack_life]);
            }



            DB::commit();
            return redirect()->route('reports_payment_success');
        }
        return redirect()->route('reports_payment_failed',['error' => $result['Message'] ?? '']);

    }





}
