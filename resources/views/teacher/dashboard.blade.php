@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('teacher-content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-blue-100 mt-2">You have {{ $todayAttendanceCount ?? 0 }} attendance records for today.</p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                    <i class="fas fa-chalkboard-teacher text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Students</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalStudents ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Today's Attendance</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $todayAttendancePercentage ?? 0 }}%</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-clipboard-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Your Class</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $class->class_name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-school text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Mark Today's Attendance</h3>
                    <p class="text-gray-600 mt-1">Record attendance for {{ now()->format('F j, Y') }}</p>
                </div>
                <a href="{{ route('teacher.attendance.index') }}"
                    class="mt-4 md:mt-0 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <i class="fas fa-pen"></i>
                    <span>Mark Attendance</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Recent Attendance</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentAttendance ?? [] as $attendance)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $attendance->student->user->name ?? 'Student' }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $attendance->date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium {{ $attendance->status == 'Present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $attendance->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent attendance records.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
