<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get the authenticated student's record
        $user = Auth::user();
        $student = $user->student()->with('class')->first();

        if (!$student) {
            return redirect()->route('login')->with('error', 'Student record not found.');
        }

        // 2. Fetch Recent Attendance (Last 5 records)
        $recentAttendance = Attendance::where('student_id', $student->id)
            ->with(['teacher.user']) // To show who marked it
            ->latest('date')
            ->take(5)
            ->get();

        // 3. Calculate Stats
        $totalAttendanceCount = Attendance::where('student_id', $student->id)->count();
        $presentCount = Attendance::where('student_id', $student->id)
            ->where('status', 'Present')
            ->count();

        // 4. Monthly Percentage (Last 30 Days)
        $startOfMonth = Carbon::now()->startOfMonth();
        $totalThisMonth = Attendance::where('student_id', $student->id)
            ->where('date', '>=', $startOfMonth)
            ->count();

        $presentThisMonth = Attendance::where('student_id', $student->id)
            ->where('date', '>=', $startOfMonth)
            ->where('status', 'Present')
            ->count();

        $monthlyAttendance = $totalThisMonth > 0
            ? round(($presentThisMonth / $totalThisMonth) * 100, 1)
            : 0;

        // 5. Data for the Chart (Last 4 weeks)
        // You can make this dynamic later, for now we pass variables
        $chartData = [85, 90, 88, 92]; // Replace with dynamic logic if needed

        return view('student.dashboard', [
            'student' => $student,
            'class' => $student->class,
            'recentAttendance' => $recentAttendance,
            'totalAttendance' => $presentCount, // Count of "Present" marks
            'monthlyAttendance' => $monthlyAttendance,
            'chartData' => $chartData
        ]);
    }
}
