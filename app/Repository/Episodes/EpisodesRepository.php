<?php
namespace App\Repository\Episodes;


use App\Interfaces\Episodes\EpisodesInterface;
use App\Models\Episode;
use App\Models\Faq;

class EpisodesRepository implements EpisodesInterface
{
    public function index()
    {
        return response_success(Episode::OrderbyDesc('id')->get());
    }

    public function store($request)
    {
        $item = Episode::create([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
            'is_active' => 1,

        ]);
        return response_success($item);
    }

    public function update($request,$item)
    {
        $item->update([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'sale' => $request->sale,
            'description' => $request->description,
        ]);
        return response_success($item);
    }

    public function delete($item)
    {
        $item->delete();
        return response_success(true,'item deleted success');

    }


}
