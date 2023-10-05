<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;

class AvailableRoomController extends Controller
{
    public function __invoke()
    {

        $report = new DashboardReporting();
        $availableRoomTypes = $report->availableRooms();

        return $availableRoomTypes;
    }
}
