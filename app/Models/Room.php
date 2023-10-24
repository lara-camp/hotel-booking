<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeSearch($query, array $filters) {

        $query->when($filters['from_date'] ?? false, function($query) use($filters) {
            $query->when($filters['to_date'] ?? false, function($query) use($filters) {
                $query->whereDoesntHave('reservations',function($query) use ($filters) {
                    $query->whereBetween('from_date',[$filters['from_date'], $filters['to_date']])
                    ->orWhereBetween('to_date', [$filters['from_date'], $filters['to_date']])
                    //check if the reservation date is between from_date and to
                    ->orWhere(function ($query) use ($filters) {
                        $query->where('from_date', '<=', $filters['from_date'])
                            ->where('to_date', '>=', $filters['to_date']);
                    });
                });
            });
        });
    }

    public function reservations() {
        return $this->belongsToMany(Reservation::class);
    }

    public function roomType() {
        return $this->belongsTo(RoomType::class)->withTrashed();
    }
}
