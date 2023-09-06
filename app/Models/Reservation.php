<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservationDetails() {
        return $this->hasMany(ReservationDetail::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
