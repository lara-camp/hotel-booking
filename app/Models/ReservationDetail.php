<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationDetail extends Pivot
{
    use HasFactory;

//    protected $guarded = [];
//
//    public function reservation() {
//        return $this->belongsTo(Reservation::class);
//    }
//
//    public function rooms() {
//        return $this->belongsTo(Room::class);
//    }
}
