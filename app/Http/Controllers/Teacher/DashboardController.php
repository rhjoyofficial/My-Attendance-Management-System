<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Get teacher record with their assigned class
        $teacher = $user->teacher()->with('classRoom')->first();

        if (!$teacher || !$teacher->class_id) {
            return view('teacher.dashboard')->with('error', 'No class assigned to you.');
        }

        $class = $teacher->classRoom;

        // 1. Total Students in the Teacher's Class
        $totalStudents = Student::where('class_id', $teacher->class_id)->count();

        // 2. Today's Attendance Stats
        $todayAttendance = Attendance::where('class_id', $teacher->class_id)
            ->whereDate('date', Carbon::today())
            ->get();

        $todayAttendanceCount = $todayAttendance->count();
        $presentToday = $todayAttendance->where('status', 'Present')->count();

        // Calculate percentage (Present / Total Students in Class)
        $todayAttendancePercentage = $totalStudents > 0
            ? round(($presentToday / $totalStudents) * 100, 1)
            : 0;

        // 3. Recent Activity (Last 5 records marked by this teacher)
        $recentAttendance = Attendance::where('teacher_id', $teacher->id)
            ->with('student.user')
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'class',
            'totalStudents',
            'todayAttendanceCount',
            'todayAttendancePercentage',
            'recentAttendance'
        ));
    }
}
