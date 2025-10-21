@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* Styling tabel biar rapi */
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

table.dataTable tbody tr:hover {
    background-color: #f1f5f9;
}

table.dataTable tbody img {
    max-height: 60px;
    border-radius: 6px;
    object-fit: cover;
}
</style>

<div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
    <!-- Filter -->
    <div class="flex items-center space-x-3 mb-4">
        <input type="date" id="dateFilter" class="border border-gray-300 rounded-lg px-3 py-1">
        
        <select id="classFilter" class="border border-gray-300 rounded-lg px-3 py-1">
            <option value="">Semua Kelas</option>
            @foreach(\App\Models\Classroom::all() as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-1">
            <option value="">Semua Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Telat">Telat</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
        </select>

        <button id="exportExcel" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Export Excel
        </button>
    </div>

    <!-- Tabel -->
    <table id="attendanceTable" class="display w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Email</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Metode</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 🔹 Inisialisasi DataTables
    let table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: "{{ route('admin.attendances.data') }}",
                type: "GET",
                data: function (d) {
                    d.date = $('#dateFilter').val();
                    d.status = $('#statusFilter').val();
                    d.class_id = $('#classFilter').val();
                }
            },

            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
            }
        },
        order: [[4, 'desc'], [5, 'desc']],
        columns: [
            { data: 0, name: 'id' },
            { data: 1, name: 'name' },
            { data: 2, name: 'class' },
            { data: 3, name: 'email' },
            { data: 4, name: 'date' },
            { data: 5, name: 'time' },
            { data: 6, name: 'status' },
            { data: 7, name: 'method' },
            {
                data: 8,
                render: function (data, type, row) {
                    if (row[7] === 'qr') {
                        return '<span class="text-purple-700 font-semibold">QR Verified</span>';
                    } else if (data && data.includes('.jpg') || data.includes('.png')) {
                        return `<a href="/storage/${data}" target="_blank">
                                    <img src="/storage/${data}" width="60" height="60" style="border-radius:8px">
                                </a>`;
                    } else if (data) {
                        return `<em>${data}</em>`;
                    } else {
                        return '<em>-</em>';
                    }
                }
            }
        ]
    });

    // 🔹 Filter otomatis
    $('#dateFilter, #statusFilter, #classFilter').on('change', function() {
        table.ajax.reload();
    });

    // 🔹 Export ke Excel
    $('#exportExcel').on('click', function() {
        const date = $('#dateFilter').val();
        const status = $('#statusFilter').val();
        const class_id = $('#classFilter').val();

        const url = `{{ route('admin.attendances.export') }}?date=${date}&status=${status}&class_id=${class_id}`;
        window.location.href = url;
    });
});
</script>
@endsection
