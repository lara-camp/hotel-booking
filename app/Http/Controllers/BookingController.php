<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $popularRoomTypes = $report->popularRoomTypes();
        
        $filters = ['from_date' =>"2023-10-04", 'to_date'=> "2023-10-05"];

        $availableRooms = Room::search($filters)->get();

        //Check if there is search query or not
        if(request()->has('from_date')  && request()->has('to_date')) {
            
            $searchRooms = [];
            //avaiable rooms but only one room for a particular room-type
            foreach ($availableRooms as $availableRoom) {
                if(!isset($searchRooms[$availableRoom->room_type_id])) $searchRooms[$availableRoom->room_type_id] = $availableRoom;
            }
            return Inertia::render('Booking/Index',[
                'searchRooms' => $searchRooms
            ]);
        } else {
            return Inertia::render('Index',[
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
        dd($request->all());
        DB::beginTransaction();

        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::user()->id;
            $reservation->from_date =date('Y-m-d',strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d',strtotime($request->to_date));
            $reservation->status = $request->status;
            $reservation->checkin_time = $request->checkin_time;
            $reservation->checkout_time = $request->checkout_time;
            $reservation->save();

            $reservation->rooms()->attach($request->room_id);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

}
