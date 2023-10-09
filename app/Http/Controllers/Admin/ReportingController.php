<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Reporting\DashboardReporting;
use Inertia\Inertia;

class ReportingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //this month
        date_default_timezone_set("Asia/Yangon");
        $month = date('M');
        $start_date = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_date = date('Y-m-d h:i:s', strtotime('+1 month', strtotime($month)));

        $report = new DashboardReporting();

        $todayAvailableRoomTypes = $report->availableRoomTypes();
        $todayAvailableRooms = $report->availableRooms();
        $todayReservedRooms = $report->reservedRooms();

        $monthlyPopularRoomTypes = $report->popularRoomTypes($start_date, $end_date);
        $monthlyGuests = Reservation::whereBetween('from_date',[$start_date,$end_date])
                                ->sum('total_person');

        $monthlyAmount = Reservation::whereBetween('from_date', [$start_date, $end_date])
                                ->sum('total_price');

        return Inertia::render("Dashboard", [
            'todayAvailableRoomTypes' =>$todayAvailableRoomTypes,
            'todayAvailableRooms'=>$todayAvailableRooms,
            'todayReservedRooms'=>$todayReservedRooms,
            'monthlyPopularRoomTypes'=>$monthlyPopularRoomTypes,
            'monthlyGuests'=>$monthlyGuests,
            'monthlyAmount'=>$monthlyAmount
        ]);
    }
}
