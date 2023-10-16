<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ReportingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $month = date('M');
        $start_date = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_date = date('Y-m-d h:i:s', strtotime('+1 month', strtotime($month)));

        if(Cache::has('cache_data')){
            $data = Cache::get('cache_data');
        }
        else{
            $report = new DashboardReporting();
            $todayAvailableRoomTypes = $report->availableRoomTypes();
            $todayAvailableRooms = $report->availableRooms();
            $todayReservedRooms = $report->reservedRooms();

            $monthlyPopularRoomTypes = $report->popularRoomTypes($start_date, $end_date);
            $monthlyGuests = Reservation::whereBetween('from_date',[$start_date,$end_date])
                                    ->sum('total_person');

            $monthlyAmount = Reservation::whereBetween('from_date', [$start_date, $end_date])
                                    ->sum('total_price');

            $data = [
                'todayAvailableRoomTypes' =>$todayAvailableRoomTypes,
                'todayAvailableRooms'=>$todayAvailableRooms,
                'todayReservedRooms'=>$todayReservedRooms,
                'monthlyPopularRoomTypes'=>$monthlyPopularRoomTypes,
                'monthlyGuests'=>$monthlyGuests,
                'monthlyAmount'=>$monthlyAmount
            ];
            Cache::put('cache_data',$data,now()->addMinutes(30));
        }
        return Inertia::render("Dashboard", $data);
    }
}
