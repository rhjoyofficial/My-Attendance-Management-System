@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Students</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_students'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Teachers</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_teachers'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Classes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_classes'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-school text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Today's Attendance</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            {{ $stats['today_attendance'] }}%
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="fas fa-clipboard-check text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow border border-gray-100 max-h-96 overflow-y-auto no-scrollbar">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Attendance</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recent_attendance ?? [] as $attendance)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $attendance->student->name ?? 'Student' }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $attendance->class->name ?? 'Class' }}</p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium {{ strtolower($attendance->status) == 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No attendance records yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.classes.create') }}"
                            class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center hover:bg-blue-100 transition">
                            <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                            <p class="font-medium text-blue-800">Add Class</p>
                        </a>
                        <a href="{{ route('admin.teachers.create') }}"
                            class="bg-green-50 border border-green-200 rounded-lg p-4 text-center hover:bg-green-100 transition">
                            <i class="fas fa-user-plus text-green-600 text-2xl mb-2"></i>
                            <p class="font-medium text-green-800">Add Teacher</p>
                        </a>
                        <a href="{{ route('admin.students.create') }}"
                            class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center hover:bg-purple-100 transition">
                            <i class="fas fa-user-graduate text-purple-600 text-2xl mb-2"></i>
                            <p class="font-medium text-purple-800">Add Student</p>
                        </a>
                        <a href="{{ route('admin.attendance.index') }}"
                            class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center hover:bg-yellow-100 transition">
                            <i class="fas fa-clipboard-list text-yellow-600 text-2xl mb-2"></i>
                            <p class="font-medium text-yellow-800">View Attendance</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
