<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Reporting\DashboardReporting;
use Illuminate\Http\Request;

class PopularRoomTypeController extends Controller
{
    public function __invoke() {

        $report = new DashboardReporting();
        $popularRoomTypes = $report->popularRoomTypes();
    }
}
