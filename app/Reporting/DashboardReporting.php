<?php

namespace App\Reporting;

use App\Models\Reservation;
use App\Models\Room;

class DashboardReporting {

    public function popularRoomTypes($start_date, $end_date) : array {

        $reservations = Reservation::whereBetween('from_date',[$start_date,$end_date])->get();
        //calculating the times of booking a specific room type
        $room_types = [];
        foreach ($reservations as $reservation) {
            foreach ($reservation->rooms as $room) {
                $room_type = $room->roomType;
                if (!isset($room_types[$room_type->name])) $room_types[$room_type->name] = 1;
                else $room_types[$room_type->name] ++;
            }
        }
        return $room_types;
    }

    public function availableRooms($from_date = 'today', $to_date = 'today') : object {
        
        $availableRooms = Room::availableRooms($from_date,$to_date)->get();
        return $availableRooms;
    }

    //reserved rooms for today
    public function reservedRooms() : object {
        $today = date('Y-m-d', strtotime('today'));
        $reservedRooms = Room::whereHas('reservations', function($query) use ($today) {
            $query->where('from_date', '=', $today);
        })->get();
        return $reservedRooms;
    }

    public function availableRoomTypes($from_date = 'today', $to_date = 'today') : array { //[roomtype => numberOfRooms]

        $availableRooms = $this->availableRooms($from_date, $to_date);
        //calculate the numbers of available rooms depending on a particular room type
        $availableRoomTypes = [];
        foreach ($availableRooms as $availableRoom) {
            if(!isset($availableRoomTypes[$availableRoom->roomType->name])) $availableRoomTypes[$availableRoom->roomType->name] = 1;
            else $availableRoomTypes[$availableRoom->roomType->name] ++;
        }
        return $availableRoomTypes;
    }

    public function totalRooms() : int {
       return Room::all()->count();
    }
}
