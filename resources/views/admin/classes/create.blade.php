@extends('layouts.admin')

@section('title', 'Create Class')

@section('admin-content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create New Class</h1>
                <p class="text-gray-600">Add a new class to the system</p>
            </div>

            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">Class Name *</label>
                        <input type="text" name="class_name" id="class_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., Grade 10, B.Tech CSE, etc.">
                        @error('class_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <input type="text" name="section" id="section"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., A, B, Morning, etc.">
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., Mathematics, Science, etc.">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.classes.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Create Class</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
