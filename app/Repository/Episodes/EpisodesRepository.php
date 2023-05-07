<?php
namespace App\Repository\Episodes;


use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use App\Models\Faq;
use Illuminate\Support\Facades\Storage;

class EpisodesRepository implements EpisodesInterface
{
    public function index()
    {
        return response_success(Episode::OrderbyDesc('id')->get());
    }

    public function store($request)
    {
        $image=null;
        if ($request->hasFile('image')){
            $image = upload_public_image('episodes/images',$request->file('image'));
        }
        $item = Episode::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
            'image' => $image,
            'is_active' => 1,

        ]);
        return response_success($item);
    }

    public function update($request,$item)
    {
        $image=$item->image;
        if ($request->hasFile('image')){
            Storage::delete($item->image);
            $image = upload_public_image('episodes/images',$request->file('image'));
        }
        $item->update([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
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


}
