<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Episode extends Model
{
    use HasFactory;

    protected $table='episodes';
    protected $guarded=[];

    protected $appends=['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image){
            return asset(Storage::url($this->image));
        }
    }

}
