<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Reservation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [];
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
