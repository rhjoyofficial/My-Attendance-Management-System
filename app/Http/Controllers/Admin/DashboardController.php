<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $presentToday = Attendance::whereDate('date', Carbon::today())
            ->where('status', 'present')
            ->count();

        $attendancePercentage = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0;

        $stats = [
            'total_students' => $totalStudents,
            'total_teachers' => Teacher::count(),
            'total_classes' => ClassRoom::count(),
            'today_attendance' => $attendancePercentage,
        ];

        $recent_attendance = Attendance::with(['student', 'class'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_attendance'));
    }
}
