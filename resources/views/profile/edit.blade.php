@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Data Siswa</h2>

    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $student->name) }}"
                       class="border border-gray-300 rounded px-3 py-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $student->email) }}"
                       class="border border-gray-300 rounded px-3 py-2 w-full" required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('admin.students') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
