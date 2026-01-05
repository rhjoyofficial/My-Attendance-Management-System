<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;

        // 1. Base Query
        $query = $student->attendances()->with(['classRoom', 'teacher.user']);

        // 2. Apply Filters (Month and Status)
        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Calculate Stats (Total based on student, not just filtered results)
        $totalDays = $student->attendances()->count();
        $presentCount = $student->attendances()->where('status', 'Present')->count();
        $absentCount = $student->attendances()->where('status', 'Absent')->count();

        $attendancePercentage = $totalDays > 0
            ? round(($presentCount / $totalDays) * 100, 1)
            : 0;

        // 4. Get Paginated Results
        $attendances = $query->latest('date')->paginate(15)->withQueryString();

        return view('student.attendance.index', compact(
            'attendances',
            'totalDays',
            'presentCount',
            'absentCount',
            'attendancePercentage'
        ));
    }
}
