<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
 

    public function index()
    {
        $attendances = Attendance::latest()->take(5)->get();
        return view('home', compact('attendances'));
    }

    public function indexRekap()
    {
        $attendances = Attendance::all();
        $totalAttendance = Attendance::select('employee', DB::raw('count(*) as total'))
                                    ->groupBy('employee')
                                    ->get();

        return view('rekap.index', compact('attendances', 'totalAttendance'));
    }

    public function filterRekap(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        $attendances = Attendance::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalAttendance = Attendance::select('employee', DB::raw('count(*) as total'))
                                    ->whereBetween('created_at', [$startDate, $endDate])
                                    ->groupBy('employee')
                                    ->get();
                                    
        return view('rekap.index', compact('attendances', 'totalAttendance'));
    }

    public function markAttendance(Request $request)
    {
        $attendance = new Attendance();
        $attendance->employee = $request->employee;
        $attendance->attendance = $request->attendance;
        $attendance->save();

        return response()->json(['message' => 'Attendance marked successfully'], 200);
    }
}
