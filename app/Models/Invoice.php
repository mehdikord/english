<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table='invoices';

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function pack()
    {
        return $this->belongsTo(Life_Pack::class,'life_pack_id');
    }
}
