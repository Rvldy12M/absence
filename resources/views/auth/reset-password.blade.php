<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3 1.343 3 3m0 0c0 1.657-1.343 3-3 3m0 0c-1.657 0-3-1.343-3-3m0 0c0-1.657 1.343-3 3-3m0 0V7m0 11v3" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Reset Your Password</h2>
                <p class="text-blue-200 text-sm">Enter your new password below</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-700" 
                            placeholder="your@email.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">New Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-700" 
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Confirm Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-700" 
                            placeholder="••••••••">
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-900 to-slate-800 text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-900/50"
                    >
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <p class="mt-8 text-center text-sm text-slate-600">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition-colors">
                        Sign in now
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
