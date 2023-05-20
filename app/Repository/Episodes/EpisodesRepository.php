<?php
namespace App\Repository\Episodes;


use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use App\Models\Faq;
use App\Resources\Episodes\EpisodePublicResource;
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


    public function public_index()
    {
        $data = Episode::whereIs_active(true)->OrderByDesc('id')->get();
        return response_success(EpisodePublicResource::collection($data));
    }


}
