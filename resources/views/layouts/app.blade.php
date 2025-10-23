<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Attendance System')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-blue-900 to-slate-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo/Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Absenly</h1>
            </div>

            <!-- Tombol Hamburger (muncul di HP) -->
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menu Desktop -->
            <div id="menu-desktop" class="hidden md:flex items-center space-x-2">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('admin.dashboard') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.attendances') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('admin.attendances') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Kehadiran
                        </a>
                        <a href="{{ route('admin.students') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('admin.students') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Siswa
                        </a>
                        <a href="{{ route('admin.qr.generate') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('admin.qr.generate') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            QR Code
                        </a>
                    @elseif(Auth::user()->role === 'student')
                        <a href="{{ route('attendance.index') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('attendance.index') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Absen
                        </a>
                        <a href="{{ route('attendance.form') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('attendance.form') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Form Ketidakhadiran
                        </a>
                    @endif

                    <!-- User Info & Logout -->
                    <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-white/20">
                        <div class="text-right hidden md:block">
                            <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-blue-200 text-xs capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 hover:bg-red-500/20 border border-red-400/30 hover:border-red-400">
                            Logout
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="menu-mobile" class="hidden md:hidden mt-4 bg-slate-900/90 rounded-xl border border-slate-700/50 p-4 space-y-2">
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">Dashboard</a>
                    <a href="{{ route('admin.attendances') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">Kehadiran</a>
                    <a href="{{ route('admin.students') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">Siswa</a>
                    <a href="{{ route('admin.qr.generate') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">QR Code</a>
                @elseif(Auth::user()->role === 'student')
                    <a href="{{ route('attendance.index') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">Absen</a>
                    <a href="{{ route('attendance.form') }}" class="block px-4 py-2 rounded-lg text-white hover:bg-white/10">Form Ketidakhadiran</a>
                @endif

                <div class="border-t border-white/20 my-2"></div>
                <p class="text-sm text-white font-semibold">{{ Auth::user()->name }} <span class="text-blue-300">({{ Auth::user()->role }})</span></p>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="w-full px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 hover:bg-red-500/20 border border-red-400/30 hover:border-red-400">
                    Logout
                </button>
            @endif
        </div>
    </div>
</nav>

<!-- Content -->
<main class="p-6">
    @yield('content')
</main>

@yield('scripts')

<!-- Script toggle menu mobile -->
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const menuMobile = document.getElementById('menu-mobile');

    toggleBtn.addEventListener('click', () => {
        menuMobile.classList.toggle('hidden');
    });
</script>

</body>
</html>
