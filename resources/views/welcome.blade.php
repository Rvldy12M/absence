<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-900/90 to-slate-800/90 backdrop-blur-sm shadow-2xl sticky top-0 z-50 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">School Attendance</h1>
                        <p class="text-xs text-blue-200">Smart Presence System</p>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-3">
                    @if(Route::has('login'))
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="px-5 py-2.5 rounded-lg text-white font-medium transition-all duration-200 hover:bg-white/10 border border-white/20 hover:border-white/40">
                                    Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'student')
                                <a href="{{ route('attendance.index') }}" 
                                   class="px-5 py-2.5 rounded-lg text-white font-medium transition-all duration-200 hover:bg-white/10 border border-white/20 hover:border-white/40">
                                    Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-5 py-2.5 rounded-lg text-white font-medium transition-all duration-200 hover:bg-white/10">
                                Login
                            </a>
                                <a href="{{ route('publicscreen') }}" 
                                   class="px-5 py-2.5 rounded-lg bg-white text-blue-900 font-semibold transition-all duration-200 hover:bg-blue-50 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Information
                                </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div class="text-white space-y-8">
                <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mb-4">
                    <span class="text-sm font-medium text-blue-200">🎓 Modern School Solution</span>
                </div>
                
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                    Smart Attendance
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-white">
                        Management System
                    </span>
                </h1>
                
                <p class="text-xl text-blue-100 leading-relaxed">
                    Effortlessly track student attendance with QR code technology. Fast, accurate, and paperless solution for modern schools.
                </p>

                <!-- Features List -->
                <div class="grid md:grid-cols-2 gap-4 pt-8">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">QR Code Scanner</h3>
                            <p class="text-sm text-blue-200">Quick check-in with QR</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Real-time Reports</h3>
                            <p class="text-sm text-blue-200">Instant attendance data</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Secure System</h3>
                            <p class="text-sm text-blue-200">Protected student data</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Time Efficient</h3>
                            <p class="text-sm text-blue-200">Save time, go digital</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4 pt-4">
                    @if(Route::has('login'))
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg shadow-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('attendance.index') }}" 
                                   class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg shadow-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                    Go to Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}" 
                               class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg shadow-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                Information
                            </a>
                            <a href="{{ route('login') }}" 
                               class="px-8 py-4 bg-white/10 backdrop-blur-md text-white font-bold rounded-lg border-2 border-white/30 hover:bg-white/20 transition-all duration-200">
                                Sign In
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Right Content - Visual -->
            <div class="relative">
                <!-- Main Card -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl">
                    <!-- QR Code Illustration -->
                    <div class="bg-white rounded-2xl p-8 mb-6">
                        <div class="grid grid-cols-8 gap-2">
                            <!-- Simple QR Pattern -->
                            <div class="col-span-2 row-span-2 bg-blue-900 rounded"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="col-span-2 row-span-2 bg-blue-900 rounded"></div>
                            
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            
                            <div class="col-span-2 row-span-2 bg-blue-900 rounded"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="col-span-2 row-span-2 bg-blue-900 rounded"></div>
                            
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                            <div class="bg-blue-900"></div>
                            <div class="bg-slate-300"></div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md border border-white/20">
                            <div class="text-2xl font-bold text-white">500+</div>
                            <div class="text-xs text-blue-200">Students</div>
                        </div>
                        <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md border border-white/20">
                            <div class="text-2xl font-bold text-white">98%</div>
                            <div class="text-xs text-blue-200">Accuracy</div>
                        </div>
                        <div class="text-center p-4 bg-white/10 rounded-xl backdrop-blur-md border border-white/20">
                            <div class="text-2xl font-bold text-white">Fast</div>
                            <div class="text-xs text-blue-200">Check-in</div>
                        </div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl"></div>
            </div>

        </div>
    </div>

</body>
</html>