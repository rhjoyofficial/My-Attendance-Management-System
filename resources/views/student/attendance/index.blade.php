@extends('layouts.student')

@section('title', 'Attendance History')

@section('student-content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Attendance History</h1>
            <p class="text-gray-600">View your complete attendance record</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Present Days</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $presentCount ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Absent Days</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $absentCount ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Total Days</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalDays ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Percentage</p>
                    <p class="text-2xl font-bold text-purple-600 mt-1">{{ $attendancePercentage ?? 0 }}%</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between space-y-3 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <input type="month" id="monthFilter" value="{{ now()->format('Y-m') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <select id="statusFilter"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                    </select>
                </div>
                <button id="printBtn"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                    <i class="fas fa-print"></i>
                    <span>Print Report</span>
                </button>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Marked By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $attendance->date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $attendance->date->format('l') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->classRoom->class_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user-tie text-gray-600 text-sm"></i>
                                        </div>
                                        <span
                                            class="text-sm text-gray-900">{{ $attendance->teacher->user->name ?? 'Teacher' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium {{ $attendance->status == 'Present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->created_at->format('h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No attendance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($attendances->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('monthFilter').addEventListener('change', function() {
                // Add month filter logic here
                console.log('Month filter:', this.value);
            });

            document.getElementById('statusFilter').addEventListener('change', function() {
                // Add status filter logic here
                console.log('Status filter:', this.value);
            });

            document.getElementById('printBtn').addEventListener('click', function() {
                window.print();
            });
        </script>
    @endpush
@endsection
