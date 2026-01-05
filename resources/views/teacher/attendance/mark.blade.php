@extends('layouts.teacher')

@section('title', 'Mark Attendance')

@section('teacher-content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mark Attendance</h1>
            <p class="text-gray-600">Record attendance for {{ $class->class_name ?? 'your class' }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('teacher.attendance.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                        <input type="date" name="date" id="date" required
                            value="{{ old('date', now()->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="class_id" value="{{ $class->id ?? '' }}">
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roll No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($class->students ?? [] as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-gray-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $student->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-mono">{{ $student->roll_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="Present"
                                                    {{ (isset($todayAttendance[$student->id]) && $todayAttendance[$student->id] == 'Present') || !isset($todayAttendance[$student->id]) ? 'checked' : '' }}
                                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                                <span class="ml-2 text-green-700">Present</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="attendance[{{ $student->id }}]" value="Absent"
                                                    {{ isset($todayAttendance[$student->id]) && $todayAttendance[$student->id] == 'Absent' ? 'checked' : '' }}
                                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                                <span class="ml-2 text-red-700">Absent</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        No students found in this class.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-100">
                    <a href="{{ route('teacher.dashboard') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Save Attendance</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
