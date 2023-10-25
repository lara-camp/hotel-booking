<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Jobs\SendBookingMailJob;
use App\Mail\BookingNotificationMail;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Reporting\DashboardReporting;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::get(["id", "name"]);
        if (request()->has("from_date") || request()->has("to_date") || request()->has("room_type_id")) {
            $rooms       = Room::search(request(['from_date', 'to_date']))->orWhereIn("room_type_id", explode(",", request("room_type_id")))->with('roomType')->get();
            $searchRooms = [];
            //avaiable rooms but only one room for a particular room-type
            foreach ($rooms as $room) {
                if (!isset($searchRooms[$room->room_type_id]))
                    $searchRooms[$room->room_type_id] = $room;
            }
            return Inertia::render('Welcome', [
                'searchRooms' => $searchRooms,
                'roomTypes' => $roomTypes
            ]);
        }
        return Inertia::render("Welcome", [
            "roomTypes" => $roomTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $availableRooms = Room::availableRooms($request->from_date, $request->to_date)->get();
        $price = 0;
        $duration = date('d', strtotime($request->to_date))-date('d', strtotime($request->from_date))+1;
        foreach($request->room_id as $room) {
            if($availableRooms->find($room)) {
                $price += $availableRooms->find($room)->price;
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
            $reservation->total_price = $price * $duration;
            $reservation->from_date =date('Y-m-d',strtotime($request->from_date));
            $reservation->to_date = date('Y-m-d',strtotime($request->to_date));
            $reservation->save();
            $reservation->rooms()->attach($request->room_id);

            Cache::flush();

            DB::commit();
            SendBookingMailJob::dispatch($reservation, Auth::user()->email);
            // Mail::to(Auth::user()->email)->send(new BookingNotificationMail($reservation));
            return redirect()->back();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function reservations() {
        $reservations = Cache::remember("user.reservations", now()->addMinutes(30), function () {
            return Reservation::where("user_id", Auth::id())->latest()->get();
        });
        return Inertia::render("User/Reservations", [
            "reservations" => $reservations
        ]);
    }
}
