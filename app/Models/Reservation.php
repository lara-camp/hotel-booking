<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'checkin_time'=>"datetime",
        'checkout_time'=> "datetime"
    ];

    public function scopeSearch($query, array $filters) {
        $query->when($filters['from_date'] ?? false, function($query, $from_date) {
            $query->whereDate('from_date', '>=', $from_date);
        });

        $query->when($filters['to_date'] ?? false, function($query, $to_date) {
            $query->whereDate('to_date', '<=', $to_date);
        });
    }

    public function rooms() {
        return $this->belongsToMany(Room::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
