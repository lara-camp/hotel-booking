<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reporting\DashboardReporting;

class ReportingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $report = new DashboardReporting();
        $availableRoomTypes = $report->availableRooms();
        $popularRoomTypes = $report->popularRoomTypes();

        return ['availableRoomTypes' => $availableRoomTypes,
                'popularRoomTypes' => $popularRoomTypes];
    }
}
