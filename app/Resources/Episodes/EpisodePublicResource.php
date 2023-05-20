<?php
namespace App\Resources\Episodes;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodePublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'price' => $this->price,
            'sale' => $this->sale,
            'description' => $this->description,
            'image' => $this->image,
        ];
    }


}
