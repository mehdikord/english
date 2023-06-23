<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Life_Pack extends Model
{
    use HasFactory;
    protected $table='life_packs';
    protected $guarded=[];

    public function invoices()
    {
     return $this->hasMany(Invoice::class,'life_pack_id');
    }

}
