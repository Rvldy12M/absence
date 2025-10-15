@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="p-6">

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
                    <h2 class="text-lg font-bold text-white">Edit Siswa</h2>
                    <p class="text-blue-200 text-sm">Perbarui data siswa</p>
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
                            <span>Nama Panjang</span>
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
                            <span>Alamat Email</span>
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
</div>

@endsection