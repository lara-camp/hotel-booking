<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Reporting\DashboardReporting;
use Illuminate\Http\Request;
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
        $start_month = date('Y-m-d h:i:s', strtotime("$month 1"));
        $end_month = date('Y-m-d h:i:s', strtotime('+1 month', strtotime($month)));
        $report = new DashboardReporting();

        if(Cache::has('cache_data')){
            $data = Cache::get('cache_data');
        }
        else{
            $report = new DashboardReporting();
            $todayAvailableRooms = $report->availableRooms();
            $todayAvailableRoomTypes = $report->availableRoomTypes($todayAvailableRooms);
            $totalRooms = $report->totalRooms();

            $monthlyPopularRoomTypes = $report->popularRoomTypes($start_month, $end_month);
            $monthlyGuests = Reservation::withTrashed()
                                    ->whereBetween('from_date',[$start_month,$end_month])
                                    ->sum('total_person');

            $monthlyAmount = Reservation::withTrashed()
                                    ->whereBetween('from_date', [$start_month, $end_month])
                                    ->sum('total_price');

            $data = [
                'todayAvailableRoomTypes' =>$todayAvailableRoomTypes,
                'todayAvailableRooms'=>$todayAvailableRooms,
                'monthlyPopularRoomTypes'=>$monthlyPopularRoomTypes,
                'monthlyGuests'=>$monthlyGuests,
                'monthlyAmount'=>$monthlyAmount,
                'totalRooms'=>$totalRooms,
                'adminReservedReservations'=>Reservation::where('user_id', 1)->count(),
                'userReservedReservations'=>Reservation::where('user_id', 2)->count()
            ];
            Cache::put('cache_data',$data,now()->addMinutes(30));
        }
        return Inertia::render("Dashboard", $data);
    }
}
