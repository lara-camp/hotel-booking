<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Carbon::parse("2023-10-03T03:39:16.042Z")->format('Y-m-d h:i'));
        $report = new DashboardReporting();

        $month = date('M');
        $start_date = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_date = date('Y-m-d h:i:s', strtotime('+1 month', strtotime($month)));
        $popularRoomTypes = $report->popularRoomTypes($start_date,$end_date);

        $filters = ['from_date' =>"2023-10-04", 'to_date'=> "2023-10-05"];

        $availableRooms = Room::latest()->search($filters)->with("roomType")->get();
        //Check if there is search query or not
        if(request()->has('from_date')  || request()->has('to_date')) {

            $searchRooms = [];
            //avaiable rooms but only one room for a particular room-type
            foreach ($availableRooms as $availableRoom) {
                if(!isset($searchRooms[$availableRoom->room_type_id])) $searchRooms[$availableRoom->room_type_id] = $availableRoom;
            }
            return Inertia::render('Welcome',[
                'searchRooms' => $searchRooms
            ]);
        } else {
            return Inertia::render('Welcome',[
                'popularRoomTypes' => $popularRoomTypes
            ]);
        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {

        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::user()->id;
            $reservation->from_date =date('Y-m-d',strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d',strtotime($request->to_date));
            $reservation->total_person  = $request->total_person;
            $reservation->guest_name   = $request->guest_name;
            $reservation->save();
            ddd($reservation);

            $reservation->rooms()->attach($request->room_id);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

}
