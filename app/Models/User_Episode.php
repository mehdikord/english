<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Episode extends Model
{
    use HasFactory;
    protected $table='user_episodes';
    protected $guarded=[];
    const
        ACTIVE_STATUS = 'active',
        DONE_STATUS = 'done',
        PENDING_STATUS = 'pending';


    public static array $statuses = [
        self::ACTIVE_STATUS,
        self::DONE_STATUS,
        self::PENDING_STATUS

    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class,'episode_id');
    }

}
