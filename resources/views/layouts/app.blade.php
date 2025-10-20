<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Attendance System')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Absenly</h1>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-2">
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('admin.dashboard') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.attendances') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('admin.attendances') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span>Kehadiran</span>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.students') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('admin.students') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span>Siswa</span>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.qr.generate') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('admin.qr.generate') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    <span>QR Code</span>
                                </div>
                            </a>
                        @elseif(Auth::user()->role === 'student')
                            <a href="{{ route('attendance.index') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('attendance.index') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Absen</span>
                                </div>
                            </a>
                            <a href="{{ route('attendance.form') }}" 
                               class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                      {{ request()->routeIs('admin.attendances') 
                                         ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                         : 'hover:bg-white/10' }}">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span>Form Ketidakhadiran</span>
                                </div>
                            </a>
                        @endif

                        <!-- User Profile & Logout -->
                        <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-white/20">
                            <div class="text-right hidden md:block">
                                <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-blue-200 text-xs capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            
                            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                    class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 hover:bg-red-500/20 border border-red-400/30 hover:border-red-400">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span>Logout</span>
                                </div>
                            </button>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <!-- Content -->
    <main class="p-6">
        @yield('content')
    </main>
    @yield('scripts')
</body>
</html>
