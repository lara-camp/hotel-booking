<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Reservation/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Reservation/Create', [
            'rooms' => Room::where('available', true)->map(fn($room) => [
            'id' => $room->id,
            'room_number' => $room->room_number,
        ])]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $validated = $request->validate([
                'room_id.*' => 'required|exists:rooms,id',
                'total_person' => 'required|integer|min:1',
                'total_price' => 'required|integer',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'checkin_time' => 'date',
                'checkout_time' => 'date',
            ]);

            $reservation = new Reservation();
            $reservation->user_id = Auth::user()->id;
            $reservation->total_person = $request->total_person;
            $reservation->total_price = $request->total_price;
            $reservation->from_date = date('Y-m-d', strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d', strtotime($request->to_date));

//            if ($request->checkin_time && $request->checkout_time) {
//                $reservation->checkin_time = $request->checkin_time;
//                $reservation->checkout_time = $request->checkout_time;
//            }

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
    public function show(string $id)
    {
        $data = [
            'reservation' => Reservation::find($id)->get(),
            'reservation_details' => ReservationDetail::where('reservation_id', $id)->get(),
        ];

        dd($data);
        return Inertia::render('Reservation/Show', [
            'reservation' => Reservation::find($id),
            'reservation_details' => ReservationDetail::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('reservation/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}