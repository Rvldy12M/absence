@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* Biar tabel lebih lega dan rapi */
table.dataTable {
    width: 100% !important;
    border-collapse: separate !important;
    border-spacing: 0 8px !important;
}

table.dataTable thead th {
    background-color: #f8fafc;
    padding: 12px 16px !important;
    text-align: center;
    font-weight: 600;
}

table.dataTable tbody td {
    background: #fff;
    padding: 12px 16px !important;
    border: none;
    vertical-align: middle;
    text-align: center;
}

/* Efek hover biar cakep */
table.dataTable tbody tr:hover {
    background-color: #f1f5f9;
}

/* Biar gambar QR/keterangan nggak dempet */
table.dataTable tbody img {
    max-height: 60px;
    border-radius: 6px;
    object-fit: cover;
}
</style>

<div class="p-6">
    <h1 class="text-3xl font-bold mb-6 text-slate-800">Attendance Records</h1>

    
    <!-- 🔹 FILTER AREA -->

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
    <table id="attendanceTable" class="display w-full">
        <input type="date" id="dateFilter" class="form-control border border-gray-300 rounded-lg px-3 py-1">

        <div class="flex items-center space-x-3 mb-4">
            <select id="classFilter" class="border border-gray-300 rounded-lg px-3 py-1">
                <option value="">Semua Kelasㅤㅤ</option>
                @foreach(\App\Models\Classroom::all() as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

        <select id="statusFilter" class="form-select border border-gray-300 rounded-lg px-3 py-1">
            <option value="">Semua Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Telat">Telat</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>

        </select>

        <button id="exportExcel" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Export Excel
        </button>


            <thead class="bg-slate-50">
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            </div>

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
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                    }else if (row.method === 'Form' && row.notes) {
                        // Kalau metode form dan ada notes
                        return `<span class="italic text-slate-700">${row.notes}</span>`;
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

$('#exportExcel').on('click', function() {
    const date = $('#dateFilter').val();
    const status = $('#statusFilter').val();
    const class_id = $('#classFilter').val();

    const url = `{{ route('admin.attendances.export') }}?date=${date}&status=${status}&class_id=${class_id}`;
    window.location.href = url;
});

</script>

@endsection
