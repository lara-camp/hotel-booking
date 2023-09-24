<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Reservation::class, 'reservation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return Inertia::render('Reservation/Index', [
            'reservations' => Reservation::with('user', 'reservationDetails')
                ->search(request(['from_date', 'to_date']))
                ->paginate(5)
                ->withQueryString()
                ->through(fn($reservation) => [
                    'id' => $reservation->id,
                    'total_person' => $reservation->total_person,
                    'total_price' => $reservation->total_price,
                    'from_date' => $reservation->from_date,
                    'to_date' => $reservation->to_date,
                    'checkin_time' => $reservation->checkin_time,
                    'checkout_time' => $reservation->checkout_time,
                ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Reservation/Create', [
            'rooms' => Room::where('available', true)->get(['id', 'room_number'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'room_id.*' => 'required|exists:rooms,id',
            'total_person' => 'required|integer|min:1',
            'total_price' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'checkin_time' => "date|nullable",
            'checkout_time' => 'date|nullable',
        ]);


        DB::beginTransaction();

        try {
            $reservation = new Reservation();
            $reservation->user_id = Auth::user()->id;
            $reservation->total_person = $request->total_person;
            $reservation->total_price = $request->total_price;
            $reservation->from_date = date('Y-m-d', strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d', strtotime($request->to_date));
            $reservation->checkin_time = (new Carbon($request->checkin_time))->toDateTimeString();
            $reservation->checkout_time = (new Carbon($request->checkout_time))->toDateTimeString();

            $reservation->save();

            foreach($request->room_id as $room) {
                ReservationDetail::create([
                    'room_id' => $room,
                    'reservation_id' => $reservation->id,
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
    $reservation->load('reservationDetails');//also retrieve data from detail
        return Inertia::render('Reservation/Show', [
            'id' => $reservation->id,
            'total_person' => $reservation->total_person,
            'total_price' => $reservation->total_price,
            'from_date' => $reservation->from_date,
            'to_date' => $reservation->to_date,
            'room_id' => $reservation->reservationDetails()->pluck('room_id')->toArray(),
            'checkin_time' => $reservation->checkin_time ?? Carbon::now(),
            'checkout_time' => $reservation->checkout_time ?? Carbon::now(),
            'reservation_details' => $reservation->reservationDetails,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {

        return Inertia::render('Reservation/Edit', [
            'id' => $reservation->id,
            'total_person' => $reservation->total_person,
            'total_price' => $reservation->total_price,
            'from_date' => $reservation->from_date,
            'to_date' => $reservation->to_date,
            'room_id' => $reservation->reservationDetails()->pluck('room_id')->toArray(),
            'checkin_time' => $reservation->checkin_time ?? Carbon::now(),
            'checkout_time' => $reservation->checkout_time ?? Carbon::now(),
            'available_rooms' => Room::where('available', true)->get(['id', 'room_number']),
            'reservation_details' => $reservation->reservationDetails,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'room_id.*' => 'required|exists:rooms,id',
            'total_person' => 'required|integer|min:1',
            'total_price' => 'required|integer',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'checkin_time' => 'date',
            'checkout_time' => 'date',
        ]);

        //update the data from reservation
        $reservation->total_person=$request->total_person;
        $reservation->total_price=$request->total_price;
        $reservation->from_date= date('Y-m-d', strtotime($request->from_date));
        $reservation->to_date= date('Y-m-d',strtotime($request->to_date));

        //update the check in and out time if provided
        if($request->has('checkin_time')){
            $reservation->checkin_time= date('Y-m-d H:i:s', strtotime($request->checkin_time));
        }
        if($request->has('checkout_time')){
            $reservation->checkout_time= date('Y-m-d H:i:s', strtotime($request->checkout_time));
        }

        //save the changes
        $reservation->save();

        //remove the current reservation detail and will add new later on
        ReservationDetail::where('reservation_id',$reservation->id)->delete();

        //add new detail
        foreach($request->room_id as $room){
            ReservationDetail::create([
                'room_id'=>$room,
                'reservation_id'=>$reservation->id,
            ]);
        }
        //redirect, may need to update later
        return redirect()->route('admin.reservations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        ReservationDetail::where('reservation_id',$reservation->id)->delete();
        $reservation->delete();

        //redirect, may need to update later
        return redirect()->route('admin.reservations.index');
    }
}
