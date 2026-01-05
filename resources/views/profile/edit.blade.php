@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profile Settings</h1>
            <p class="text-gray-600">Manage your account information</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                        <button id="editPersonalBtn" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Edit
                        </button>
                    </div>
                    
                    <form id="personalForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="hidden" id="personalFormActions">
                            <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-100">
                                <button type="button" id="cancelPersonalBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Change Password</h3>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="flex items-center justify-end pt-4">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Profile Sidebar -->
            <div class="space-y-6">
                <!-- Profile Picture -->
                <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <div class="w-32 h-32 bg-blue-100 rounded-full mx-auto flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-5xl"></i>
                            </div>
                            <button class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                        <p class="text-gray-600 capitalize">{{ Auth::user()->roles()->first()->name ?? 'User' }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                    <h4 class="font-medium text-gray-800 mb-4">Account Information</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Last Login</span>
                            <span class="font-medium">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Account Status</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editPersonalBtn = document.getElementById('editPersonalBtn');
        const cancelPersonalBtn = document.getElementById('cancelPersonalBtn');
        const personalForm = document.getElementById('personalForm');
        const personalFormActions = document.getElementById('personalFormActions');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');

        editPersonalBtn.addEventListener('click', function() {
            nameInput.disabled = false;
            emailInput.disabled = false;
            personalFormActions.classList.remove('hidden');
            editPersonalBtn.classList.add('hidden');
        });

        cancelPersonalBtn.addEventListener('click', function() {
            nameInput.disabled = true;
            emailInput.disabled = true;
            personalFormActions.classList.add('hidden');
            editPersonalBtn.classList.remove('hidden');
            // Reset form values
            personalForm.reset();
        });
    });
</script>
@endpush
@endsection