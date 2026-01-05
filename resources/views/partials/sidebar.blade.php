<aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <div class="p-4 border-b">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center">
                <i class="fas fa-school text-white text-sm"></i>
            </div>
            <span class="font-bold text-gray-800">{{ config('app.name') }}</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        @auth
            @if (auth()->user()->isAdmin())
                <!-- Admin Links -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.classes.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.classes.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-chalkboard-teacher w-5"></i>
                    <span>Classes</span>
                </a>
                <a href="{{ route('admin.teachers.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.teachers.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-user-tie w-5"></i>
                    <span>Teachers</span>
                </a>
                <a href="{{ route('admin.students.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.students.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-user-graduate w-5"></i>
                    <span>Students</span>
                </a>
                <a href="{{ route('admin.attendance.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-clipboard-check w-5"></i>
                    <span>Attendance</span>
                </a>
            @elseif(auth()->user()->isTeacher())
                <!-- Teacher Links -->
                <a href="{{ route('teacher.dashboard') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('teacher.attendance.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('teacher.attendance.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-clipboard-check w-5"></i>
                    <span>Mark Attendance</span>
                </a>
            @elseif(auth()->user()->isStudent())
                <!-- Student Links -->
                <a href="{{ route('student.dashboard') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('student.attendance.index') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('student.attendance.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                    <i class="fas fa-history w-5"></i>
                    <span>Attendance History</span>
                </a>
            @endif

            <!-- Common Links -->
            <a href="{{ route('profile.edit') }}"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                <i class="fas fa-user-cog w-5"></i>
                <span>Profile Settings</span>
            </a>
        @endauth
    </nav>

    <div class="p-4 border-t">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700 w-full">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        @endauth
    </div>
</aside>
