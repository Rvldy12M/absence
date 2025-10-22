<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 p-4">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-900 to-slate-800 p-8 text-center">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-full mx-auto mb-4 flex items-center justify-center border border-white/20">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-blue-200 text-sm">Sign in to continue to your account</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                name="email" 
                                class="w-full pl-10 pr-4 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-700"
                                placeholder="your@email.com"
                                required
                            >
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                name="password" 
                                class="w-full pl-10 pr-4 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-700"
                                placeholder="••••••••"
                                required
                            >
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-900 border-slate-300 rounded focus:ring-blue-900">
                            <span class="ml-2 text-slate-600">Remember me</span>
                        </label>
                          <!-- 🔗 Forgot Password Link -->
                        <a href="{{ route('password.request') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition-colors">
                            Forgot password?
                        </a>
                    </div>
                    

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-900 to-slate-800 text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-900/50"
                    >
                        Sign In
                    </button>
                </form>

                <!-- Sign Up Link -->
                <p class="mt-8 text-center text-sm text-slate-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition-colors">
                        Sign up now
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>