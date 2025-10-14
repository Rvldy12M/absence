@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Welcome Card -->
    <div class="mb-8 bg-gradient-to-r from-blue-900 to-slate-800 rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-blue-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ now()->format('l, d F Y') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-8 py-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Form Absen Siswa</h2>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-lg p-4 flex items-start space-x-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-red-700 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('attendance.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Status Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wide">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-200">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span>Status Kehadiran <span class="text-red-500">*</span></span>
                        </div>
                    </label>
                    <select name="status" 
                            required
                            class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-800 bg-white">
                        <option value="">-- Kehadiran --</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                    </select>
                </div>

                <!-- Notes/Reason -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wide">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center border border-purple-200">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                            <span>Catatan / Alasan</span>
                        </div>
                    </label>
                    <textarea name="notes" 
                              rows="4"
                              placeholder="Masukkan alasan"
                              class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-800 placeholder-slate-400 resize-none"></textarea>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-yellow-900">Catatan</p>
                        <p class="text-sm text-yellow-800 mt-1">Jika kamu sakit atau izin silahkan berikan alasannya.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Submit Attendance
                </button>
            </form>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-6 max-w-2xl mx-auto p-4 bg-blue-50 rounded-lg border border-blue-200 flex items-start space-x-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-blue-900">Need Help?</p>
            <p class="text-sm text-blue-700 mt-1">Make sure to submit your attendance before the deadline. Contact your teacher if you have any issues.</p>
        </div>
    </div>
</div>

@endsection