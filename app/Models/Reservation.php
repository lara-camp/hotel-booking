<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSearch($query, array $filters) {
        $query->when($filters['from_date'] ?? false, function($query, $from_date) {
            $query->whereDate('from_date', '>=', date('Y-m-d', strtotime($from_date)));
        });

        $query->when($filters['to_date'] ?? false, function($query, $to_date) {
            $query->whereDate('to_date', '<=', date('Y-m-d', strtotime($to_date)));
        });
    }

    public function rooms() {
        return $this->belongsToMany(Room::class, 'reservation_details', 'reservation_id', 'room_id')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
