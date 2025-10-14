@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-slate-800">Attendance Records</h1>

    
    <!-- 🔹 FILTER AREA -->

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <table id="attendanceTable" class="display w-full">
        <input type="date" id="dateFilter" class="form-control" />

        <div class="flex items-center space-x-3 mb-4">
            <label for="classFilter" class="text-sm font-medium text-gray-700">Kelas:</label>
            <select id="classFilter" class="border border-gray-300 rounded-lg px-3 py-1">
                <option value="">Semua</option>
                @foreach(\App\Models\Classroom::all() as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <select id="statusFilter" class="form-select">
            <option value="">Semua Status</option>
            <option value="hadir">Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="telat">Telat</option>
        </select>

            <thead class="bg-slate-50">
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Evidence</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#attendanceTable').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: "{{ route('admin.attendances.data') }}",
            data: function (d) {
                d.date = $('#dateFilter').val();
                d.status = $('#statusFilter').val();
                d.class_id = $('#classFilter').val(); // 🔹 ambil nilai kelas
            }
        },
        order: [[4, 'desc'], [5, 'desc']], // tanggal & jam terbaru
        columns: [
            { data: "id" },
            { data: "student_name" },
            { data: "email" },
            { data: "class_name", title: "Class" },
            { data: "date" },
            { data: "time" },
            { data: "status" },
            { data: "method" },
            { 
                data: "photo",
                render: function (data, type, row) {
                    if (row.method === 'qr') {
                        return '<span style="color:purple;font-weight:bold;">QR Verified</span>';
                    } else if (row.photo) {
                        return '<a href="/storage/' + row.photo + '" target="_blank"><img src="/storage/' + row.photo + '" width="60" height="60" style="border-radius:8px"></a>';
                    } else {
                        return '<em>No evidence</em>';
                    }
                }
            }
        ]
    });

    // 🔹 Filter otomatis saat dropdown berubah
    $('#dateFilter, #statusFilter, #classFilter').on('change', function() {
        table.ajax.reload();
    });
});
</script>
@endsection
