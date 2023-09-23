<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PopularRoomTypeController extends Controller
{
    public function __invoke() {

        date_default_timezone_set("Asia/Yangon");

        $month = date('M');
        $start_date = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_date = date('M', strtotime('+1 month', strtotime($month)));
        dd($end_date);
        $reservations = Reservation::whereBetween($start_date, $end_date)
                        ->get();
        $room_types = [];
        foreach ($reservations as $reservation) {
            $rooms = $reservation->rooms;
            foreach ($rooms as $room) {
                $room_type = $room->room_type;
                $room_types[$room_type] ++;
            }
        }
    }
}
