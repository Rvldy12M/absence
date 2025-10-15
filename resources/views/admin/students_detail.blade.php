@extends('layouts.app')

@section('title', 'Details Siswa')

@section('content')
<div class="p-6">
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.students') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-3 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Back to Students</span>
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Student Details</h1>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        
        <!-- Header Section with Gradient -->
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-3xl">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-white">{{ $student->name }}</h2>
                    <p class="text-blue-200 text-sm mt-1">Student ID: {{ $student->id }}</p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-8">
            <!-- Info Grid -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                
                <!-- Email Section -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-200">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wide">Email Address</label>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <p class="text-slate-800 font-medium break-all">{{ $student->email }}</p>
                    </div>
                </div>

                <!-- Role Section -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center border border-purple-200">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wide">User Role</label>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <div class="flex items-center space-x-2">
                            @if($student->role === 'student')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11.5A2.75 2.75 0 005.75 18.5h8.5a2.75 2.75 0 002.75-2.75V4.25A2.75 2.75 0 0014.25 1.5zm0 2.75v2.75H7.5V4.25h3zm-3 11v-2.75h3V15.25h-3zm5.75 0v-2.75h3V15.25h-3z"/>
                                    </svg>
                                    Student
                                </span>
                            @elseif($student->role === 'admin')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700 border border-red-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    Administrator
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ ucfirst($student->role) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- Additional Info -->
            <div class="border-t border-slate-200 pt-8">
                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Created At -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Member Since</div>
                        <div class="text-lg font-semibold text-slate-800">
                            {{ $student->created_at->format('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $student->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Status</div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="font-semibold text-slate-800">Active</span>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Last Updated</div>
                        <div class="text-lg font-semibold text-slate-800">
                            {{ $student->updated_at->format('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $student->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.students') }}" 
                   class="inline-flex items-center px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>

                <a href="{{ route('admin.students.edit', $student->id) }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Student
                </a>
            </div>

            <!-- Delete Button (Optional - moved to right) -->
            <form action="{{ route('admin.students.delete', $student->id) }}" 
                  method="POST" 
                  class="inline-block"
                  onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </form>
        </div>

    </div>

</div>

@endsection