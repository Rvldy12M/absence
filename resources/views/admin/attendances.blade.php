@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* 🔹 Styling tabel biar lega dan rapi */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

thead th {
    background-color: #f8fafc;
    padding: 12px 16px;
    text-align: center;
    font-weight: 600;
    border-bottom: 2px solid #e2e8f0;
}

tbody td {
    background: #fff;
    padding: 12px 16px;
    border: none;
    vertical-align: middle;
    text-align: center;
}

tbody tr:hover {
    background-color: #f1f5f9;
}

/* 🔹 Gaya tombol export */
button {
    transition: all 0.2s ease;
}
button:hover {
    transform: scale(1.03);
}
</style>

@php
use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;

// Ambil filter dari request (jika ada)
$date = request('date');
$status = request('status');
$class_id = request('class_id');

// Query utama
$query = Attendance::select(
    'attendances.*',
    'users.name as student_name',
    'classrooms.name as class_name'
)
->join('users', 'users.id', '=', 'attendances.user_id')
->join('classrooms', 'users.class_id', '=', 'classrooms.id')
->orderByDesc('attendances.date')
->orderByDesc('attendances.time');

// Filter opsional
if ($date) {
    $query->whereDate('attendances.date', $date);
}
if ($status) {
    $query->where('attendances.status', $status);
}
if ($class_id) {
    $query->where('classrooms.id', $class_id);
}

// Ambil hasil
$attendances = $query->get();
@endphp

<div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
    <!-- 🔹 Filter -->
    <form method="GET" action="{{ route('admin.attendances') }}" class="flex items-center space-x-3 mb-5">
        <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded-lg px-3 py-1">

        <select name="class_id" class="border border-gray-300 rounded-lg px-3 py-1">
            <option value="">Semua Kelas</option>
            @foreach(Classroom::all() as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1">
            <option value="">Semua Status</option>
            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="Telat" {{ request('status') == 'Telat' ? 'selected' : '' }}>Telat</option>
            <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>

        <a href="{{ route('admin.attendances.export', request()->query()) }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Export Excel
        </a>
    </form>

    <!-- 🔹 Tabel Kehadiran -->
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th>ID</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Metode</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $att)
                <tr class="hover:bg-slate-50">
                    <td>{{ $att->id }}</td>
                    <td>{{ $att->student_name }}</td>
                    <td>{{ $att->class_name }}</td>
                    <td>{{ $att->date }}</td>
                    <td>{{ $att->time }}</td>
                    <td class="font-semibold 
                        @if($att->status == 'Hadir') text-green-600
                        @elseif($att->status == 'Telat') text-yellow-600
                        @elseif($att->status == 'Izin') text-blue-600
                        @elseif($att->status == 'Sakit') text-purple-600
                        @else text-red-600 @endif">
                        {{ $att->status }}
                    </td>
                    <td>{{ $att->method ?? '-' }}</td>
                    <td>
                        @if ($att->method === 'qr')
                            <span style="color:purple;font-weight:bold;">QR Verified</span>
                        @elseif ($att->evidence)
                            <a href="/storage/{{ $att->evidence }}" target="_blank">
                                <img src="/storage/{{ $att->evidence }}" width="60" height="60" class="rounded-md">
                            </a>
                        @elseif ($att->description)
                            <span class="italic text-slate-700">{{ $att->description }}</span>
                        @else
                            <em>No evidence</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-slate-500 py-3">Belum ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
