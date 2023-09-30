<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;

class AvailableRoomController extends Controller
{
    public function __invoke()
    {
        //get reservations of today
        $today = date('Y-m-d', strtotime('today'));
        $reservations = Reservation::select('id')
            ->where(function($query) use ($today) {
                $query->where('from_date', '=', $today)
                    ->orWhere('from_date', '<', $today);
            })
            ->where(function($query) use ($today) {
                $query->where('to_date', '=', $today)
                    ->orWhere('to_date', '>', $today);
            })
            ->get();
        $takenRooms   = [];
        //get taken rooms of today reservations
        foreach ($reservations as $reservation) {
            foreach ($reservation->rooms as $room) {
                $takenRooms[] = $room->id;
            }
        }
        //get available rooms (rooms except taken rooms)
        $availableRooms = Room::select('id','room_type_id')->whereNotIn('id',$takenRooms)->get();

        //calculate the numbers of available rooms depending on a particular room type
        $availableRoomTypes = [];
        foreach ($availableRooms as $availableRoom) {
            if(!isset($availableRoomTypes[$availableRoom->roomType->name])) $availableRoomTypes[$availableRoom->roomType->name] = 1;
            else $availableRoomTypes[$availableRoom->roomType->name] ++;
        }

        return $availableRoomTypes;
    }
}
