<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subs()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getRouteKeyName()
    {
        return 'event_id';   
    }
}
