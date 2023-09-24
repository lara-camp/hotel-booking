<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservations() {
        return $this->belongsToMany(Reservation::class, 'reservation_details', 'room_id', 'reservation_id')->withTimestamps();
    }

    public function roomType() {
        return $this->belongsTo(RoomType::class)->withTrashed();
    }
}
