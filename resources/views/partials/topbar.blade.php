<header class="bg-white border-b border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <button class="lg:hidden text-gray-500">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <div class="hidden md:block">
                <h1 class="text-xl font-semibold text-gray-800">
                    @yield('page-title', 'Dashboard')
                </h1>
                <p class="text-sm text-gray-500">
                    {{ now()->format('l, F j, Y') }}
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative">
                <i class="fas fa-bell text-gray-500 text-lg hover:text-blue-600 cursor-pointer"></i>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
            </div>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="font-medium text-gray-800">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-sm text-gray-500 capitalize">{{ Auth::user()->roles()->first()->name ?? 'User' }}
                        </p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-cog mr-2"></i> Profile Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
