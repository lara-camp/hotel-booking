<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'rooms');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Room/Index', [
            'rooms' => Room::paginate(5)->through(fn($room) => [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'room_type' => $room->roomType->title,
                'price' => $room->price,
                'can' => [
                    'update_room' => Auth::user()->can('update', $room),
                ]
            ]),
            'can' =>[
                'create_room' => Auth::user()->can('create', Room::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Room/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|integer',
            'available' => 'required|boolean',
        ]);

        Room::create($validated);

        return redirect()->route('admin.room.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Room/Show', [
            'room' => Room::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Room/Edit', [
            'room' => Room::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number'.$id,
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|integer',
            'available' => 'required|boolean',
        ]);

        return redirect()->route('admin.rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        $room->delete();

        return redirect()->route('admin.rooms.index');
    }
}
