<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
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

    public function archives() {
        return Inertia::render('RoomType/DeletedRoomType', [
            'room_types' => RoomType::onlyTrashed()
                                    ->paginate(5)
                                    ->through(fn($room_type) => [
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

    public function restore($id) {
        $room_type = RoomType::onlyTrashed()->findOrFail($id);
        $room_type->restore();

        return redirect()->route('admin.room-types.index')->with('status', 'The room is restored');
    }

    public function forceDelete($id) {
        $room_type = RoomType::onlyTrashed()->findOrFail($id);
        $room_type->forceDelete();

        // Toast not shown yet
        return redirect()->route('admin.room-types.index');
    }
}
