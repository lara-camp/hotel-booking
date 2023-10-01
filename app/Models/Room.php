<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function reservations() {
        return $this->belongsToMany(Reservation::class);
    }

    public function roomType() {
        return $this->belongsTo(RoomType::class)->withTrashed();
    }
}
