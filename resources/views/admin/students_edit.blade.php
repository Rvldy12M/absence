@extends('layouts.app')

@section('title', 'Edit Student')

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
            <h1 class="text-3xl font-bold text-slate-800">Edit Student Information</h1>
            <p class="text-slate-600 mt-1">Update the student's details below</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        
        <!-- Header Section with Gradient -->
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-8 py-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Edit Student</h2>
                    <p class="text-blue-200 text-sm">Modify student information</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-8">
        <form id="edit-form" action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-6">

                @csrf


                <!-- Name Field -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wide">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-200">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span>Full Name</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $student->name) }}"
                               class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-800 placeholder-slate-400"
                               placeholder="Enter student's full name"
                               required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-2 inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Dropdown Kelas --}}
        <div class="mb-3">
            <label class="block font-semibold text-sm mb-1">Kelas</label>
            <select name="class_id" id="class_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" required>
                <option value="" disabled selected>Pilih Kelas</option>
                @foreach(\App\Models\Classroom::all() as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>


                <!-- Email Field -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wide">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center border border-purple-200">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span>Email Address</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $student->email) }}"
                               class="w-full px-5 py-3 border-2 border-slate-200 rounded-lg focus:border-blue-900 focus:ring-4 focus:ring-blue-900/10 outline-none transition-all duration-200 text-slate-800 placeholder-slate-400"
                               placeholder="Enter student's email address"
                               required>
                        @error('email')
                            <span class="text-red-500 text-sm mt-2 inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">Note</h3>
                            <p class="text-sm text-blue-700 mt-1">Make sure the email is unique and valid. The student will use this email to access their account.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Action Buttons Section -->
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.students') }}" 
               class="inline-flex items-center px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Cancel
            </a>

            <button form="edit-form" 
                    type="submit" 
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
        </div>
    </div>

    <!-- Helper Text -->
    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200 flex items-start space-x-3">
        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-yellow-900">Required Fields</p>
            <p class="text-sm text-yellow-800">All fields marked are required to update student information.</p>
        </div>
    </div>

</div>

@endsection