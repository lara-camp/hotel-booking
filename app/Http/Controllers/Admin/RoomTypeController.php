<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('RoomType/Index', [
            'room_types' => RoomType::latest('id')
                ->paginate(5)
                ->through(fn ($room_type) => [
                    'id' => $room_type->id,
                    'name' => $room_type->name
                ])
        ]);
    }

    public function store(StoreRoomTypeRequest $request)
    {
        $room_type = new RoomType();
        $room_type->name = $request->name;
        $room_type->save();

        return to_route('admin.room-types.index')->with('status', 'A new room is created successfully');
    }

    public function update(UpdateRoomTypeRequest $request, RoomType $room_type)
    {
        $room_type->name = $request->name;
        $room_type->update();

        return to_route('admin.room-types.index')->with('status', 'The room type is updated successfully!');
    }

    public function destroy(RoomType $room_type)
    {
        $room_type->delete();
        return to_route('admin.room-types.index')->with('status', 'The room type is deleted successfully');
    }
}
