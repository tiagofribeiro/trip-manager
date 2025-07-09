<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TripRequest extends Model
{
    use HasUuids;
    
    protected $keytype = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'destination',
        'departure_date',
        'return_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
