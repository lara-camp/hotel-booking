<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class RoomTypeController extends Controller
{
    public function index()
    {
        if(Cache::has('roomtype_list'.request('page',1))){
            $room_types = Cache::get('roomtype_list'.request('page',1));
        }
        else{
            $room_types = RoomType::latest('id')
            ->paginate(5)
            ->through(fn ($room_type) => [
                'id' => $room_type->id,
                'name' => $room_type->name
            ]);
            Cache::put('roomtype_list'.request('page',1),$room_types,now()->addMinutes(30));
        }
        return Inertia::render('RoomType/Index', [
            'room_types' => $room_types
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
        Cache::flush();
        return to_route('admin.room-types.index')->with('status', 'A new room is created successfully');
    }

    public function update(UpdateRoomTypeRequest $request, RoomType $room_type)
    {
        $room_type->name = $request->name;
        $room_type->update();
        Cache::flush();
        return to_route('admin.room-types.index')->with('status', 'The room type is updated successfully!');
    }

    public function destroy(RoomType $room_type)
    {
        $room_type->delete();
        Cache::flush();
        return to_route('admin.room-types.index')->with('status', 'The room type is deleted successfully');
    }

    public function restore($id) {
        $room_type = RoomType::onlyTrashed()->findOrFail($id);
        $room_type->restore();
        Cache::flush();
        return redirect()->route('admin.room-types.archives')->with('status', 'The room type is restored');
    }

    public function forceDelete($id) {
        $room_type = RoomType::onlyTrashed()->findOrFail($id);
        $room_type->forceDelete();
        Cache::flush();
        // Toast not shown yet
        return redirect()->route('admin.room-types.archives');
    }
}
