@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Tambah Siswa Baru</h2>

    {{-- Notifikasi Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Siswa --}}
    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf

        {{-- Nama --}}
        <div class="mb-3">
            <label class="block font-semibold text-sm mb-1">Nama</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" required>
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

        {{-- Email --}}
        <div class="mb-3">
            <label class="block font-semibold text-sm mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="block font-semibold text-sm mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.students') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
