<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCall extends Model
{
    /** @use HasFactory<\Database\Factories\VideoCallFactory> */
    use HasFactory;
    protected $fillable = [
        'main_user',
        'main_role',
        'secondary_user',
        'secondary_role',
        'room',
        'status',
        'peer_id',
        'camera',
        'audio',
        'direction',
        'count',
        'date_start',
        'date_end',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'secondary_user', 'username');
    }
}
