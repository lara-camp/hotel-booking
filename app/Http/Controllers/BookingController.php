<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Mail\BookingNotificationMail;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {      
        $rooms = Room::search(request(['from_date', 'to_date']))->get();
        $searchRooms = [];
        //avaiable rooms but only one room for a particular room-type
        foreach ($rooms as $room) {
            if(!isset($searchRooms[$room->room_type_id])) $searchRooms[$room->room_type_id] = $room;
        }
        return Inertia::render('Welcome',[
            'searchRooms' => $searchRooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {   
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));

        $report = new DashboardReporting();
        $availableRooms = $report->availableRooms($from_date, $to_date);
        
        $total_price = 0;

        foreach($request->room_id as $room) {
            if($availableRooms->find($room)) {
                $total_price += $availableRooms->find($room)->price;
            } else {
                throw ValidationException::withMessages(['room_id' => "Some of the rooms are reserved on given date."]);
            }
        }

        DB::beginTransaction();

        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::user()->id;
            $reservation->guest_name = $request->guest_name;
            $reservation->total_person = $request->total_person;
            $reservation->total_price = $total_price;
            $reservation->from_date =date('Y-m-d',strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d',strtotime($request->to_date));
            $reservation->checkin_time = $request->checkin_time;
            $reservation->checkout_time = $request->checkout_time;
            $reservation->save();

            $reservation->rooms()->attach($request->room_id);

            DB::commit();
            Mail::to(Auth::user()->email)->send(new BookingNotificationMail($reservation));
            return redirect()->route('admin.reservations.index');

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

}
