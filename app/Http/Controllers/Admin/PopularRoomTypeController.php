<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PopularRoomTypeController extends Controller
{
    public function __invoke() {

        //defining the date to get reservations
        date_default_timezone_set("Asia/Yangon");
        $month = date('M');
        $start_date = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_date = date('Y-m-d h:i:s', strtotime('+1 month', strtotime($month)));
        $reservations = Reservation::whereBetween('from_date',[$start_date,$end_date])
                        ->get();
        //calculating the times of booking a specific room type
        $room_types = [];
        foreach ($reservations as $reservation) {
            $rooms = $reservation->rooms;
            foreach ($rooms as $room) {
                $room_type = $room->roomType;
                if (!isset($room_types[$room_type->name])) $room_types[$room_type->name] = 1;
                else $room_types[$room_type->name] ++;
            }
        }
        return $room_types;
    }
}
