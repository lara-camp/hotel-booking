<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Room/Index', [
            'rooms' => Room::with('roomType')
                ->when($request->filter_room_types ?? false, function($query, $filter_room_types) {
                    $query->whereIn('room_type_id', $filter_room_types);
                })
                ->paginate(5)
                ->through(fn($room) => [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'room_type' => $room->roomType->name,
                'bed_type' => $room->bed_type,
                'number_of_bed' => $room->number_of_bed,
                'price' => $room->price,

            ]),
            'room_types' => RoomType::with('rooms')->get(['id', 'name']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Room/Create', [
            'room_type' => RoomType::with('rooms')->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        DB::beginTransaction();
        $room = new Room();
        $room->room_number = $request->room_number;
        $room->number_of_bed = $request->number_of_bed;
        $room->room_type_id  = $request->room_type_id;
        $room->price = $request->price;
        $room->bed_type = $request->bed_type;
        $room->save();
        DB::commit();

        return redirect()->route('admin.rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return Inertia::render('Room/Show', [
            'room' => $room
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return Inertia::render('Room/Edit', [
            'id' => $room->id,
            'room_number' => $room->room_number,
            'number_of_bed' => $room->number_of_bed,
            'price' => $room->price,
            'bed_type' => $room->bed_type,
            'room_type_id' => $room->room_type_id,
            'room_type' => RoomType::all(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {

        DB::beginTransaction();
        $room->room_number = $request->room_number;
        $room->number_of_bed = $request->number_of_bed;
        $room->room_type_id  = $request->room_type_id;
        $room->price = $request->price;
        $room->bed_type = $request->bed_type;
        $room->save();
        DB::commit();

        return redirect()->route('admin.rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index');
    }

    public function archives() {
        return Inertia::render('Room/DeletedRoom', [
            'rooms' => Room::onlyTrashed()
                            ->paginate(5)
                            ->through(fn($room) => [
                                'id' => $room->id,
                                'room_number' => $room->room_number
                            ]),
        ]);
    }

    public function restore($id) {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->restore();

        return redirect()->route('admin.rooms.index')->with('status', 'The room is restored');
    }

    public function forceDelete($id) {
        $room = Room::onlyTrashed()->findOrFail($id);
        $room->forceDelete();

        // Toast not shown yet
        return redirect()->route('admin.rooms.index');
    }
}
