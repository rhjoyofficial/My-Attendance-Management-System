<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $class = Auth::user()->teacher->classRoom()->with('students.user')->first();

        $todayAttendance = Attendance::where('class_id', $class->id)
            ->whereDate('date', now())
            ->pluck('status', 'student_id');

        return view('teacher.attendance.mark', compact('class', 'todayAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'attendance' => 'required|array',
            'class_id' => 'required|exists:classes,id'
        ]);

        $teacherId = Auth::user()->teacher->id;

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'class_id' => $request->class_id,
                    'teacher_id' => $teacherId,
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Attendance recorded successfully!');
    }
}
