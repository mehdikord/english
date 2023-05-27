<?php
namespace App\Repository\Episodes;


use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use App\Models\Faq;
use App\Models\Invoice;
use App\Models\User_Episode;
use App\Resources\Episodes\EpisodePublicResource;
use App\Services\Zarinpal\ZarinpalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EpisodesRepository implements EpisodesInterface
{
    public $zarinpal_service;
    public function __construct()
    {
        $this->zarinpal_service = new ZarinpalService();

    }

    public function index()
    {
        return response_success(Episode::OrderbyDesc('id')->get());
    }

    public function store($request)
    {
        $image=null;
        $file=null;
        if ($request->hasFile('image')){
            $image = upload_public_file('episodes/images',$request->file('image'));
        }
        if ($request->hasFile('file')){
            $file = upload_public_file('files/episodes',$request->file('file'));
        }


        $item = Episode::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
            'image' => $image,
            'file' => $file,
            'is_active' => 1,

        ]);
        return response_success($item);
    }

    public function update($request,$item)
    {
        $image=$item->image;
        if ($request->hasFile('image')){
            if ($image){
                Storage::delete($item->image);
            }
            $image = upload_public_file('episodes/images',$request->file('image'));
        }
        $file=$item->file;
        if ($request->hasFile('file')){
            if ($file){
                Storage::delete($item->file);
            }
            $file = upload_public_file('files/episodes',$request->file('file'));
        }

        $item->update([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
            'file' => $file,
            'image' => $image,

        ]);
        return response_success($item);
    }

    public function delete($item)
    {
        $item->delete();
        return response_success(true,'item deleted success');

    }

    public function activation($item)
    {
        $item->update(['is_active' => !$item->is_active]);
        return response_success(true);

    }

    public function download($item)
    {
        if ($item->file){
            return Storage::download($item->file);
        }
    }


    public function user_index()
    {
        $data = auth('users')->user()->episodes();
        return response_success($data->with('episode')->orderByDesc('id')->get());

    }

    public function user_active()
    {
        $data = auth('users')->user()->episodes()->where('status',User_Episode::ACTIVE_STATUS)->first();
        return response_success($data);
    }

    public function user_buy($item)
    {
        if (!$item->is_active){
            return response_custom_error('episode is not active');
        }
        DB::beginTransaction();
        $invoice = Invoice::create([
            'user_id' => auth('users')->id(),
            'title' => "Buy episode : $item->title",
            'method' => 'online',
            'episode' =>$item->id,
            'gateway'=>"Zarinpal",
        ]);
        $invoice->update(['code' => helpers_random_code($invoice->id,13)]);
        //start payment request
        if (!empty($item->sale)){
            $amount = $item->sale;
        }else{
            $amount = $item->price;
        }
        $callback = url('api/users/callbacks/plans/payments/customer');
        $invoice->update(['price' => $amount]);
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
    public function public_index()
    {
        $data = Episode::whereIs_active(true)->OrderByDesc('id')->get();
        return response_success(EpisodePublicResource::collection($data));
    }









}
