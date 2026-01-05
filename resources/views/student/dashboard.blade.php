@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('student-content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-xl shadow text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-green-100 mt-2">Your attendance for this month: {{ $monthlyAttendance ?? 0 }}%</p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                    <i class="fas fa-user-graduate text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Your Class</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $class->class_name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-school text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Roll Number</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $student->roll_number ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-id-card text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Attendance</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalAttendance ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-clipboard-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Chart -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Attendance Overview</h3>
                    <p class="text-gray-600">Last 30 days</p>
                </div>
                <a href="{{ route('student.attendance.index') }}"
                    class="text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                    <span>View All</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="h-64">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="bg-white rounded-xl shadow border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Recent Attendance</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentAttendance ?? [] as $attendance)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 {{ $attendance->status == 'Present' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                    <i
                                        class="fas {{ $attendance->status == 'Present' ? 'fa-check text-green-600' : 'fa-times text-red-600' }}"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $attendance->date->format('l, F j, Y') }}</p>
                                    <p class="text-sm text-gray-500">Marked by:
                                        {{ $attendance->teacher->user->name ?? 'Teacher' }}</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium {{ $attendance->status == 'Present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $attendance->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No attendance records found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('attendanceChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: 'Attendance Percentage',
                            data: @json($chartData), // This makes it dynamic from PHP
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
