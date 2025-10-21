@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* Styling tabel biar lebih rapi */
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
    <!-- 🔹 Filter Area -->
    <div class="flex items-center space-x-3 mb-4">
        <input type="date" id="dateFilter" class="form-control border border-gray-300 rounded-lg px-3 py-1">
        
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

    <!-- 🔹 Table Area -->
    <table id="attendanceTable" class="display w-full">
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
        <tbody>
            <tr>
                <td colspan="9" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
// ✅ Setup CSRF Token biar aman di hosting
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function () {
    // ✅ Inisialisasi DataTables
    const table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/attendances/data",
            type: "GET",
            data: function (d) {
                d.date = $('#dateFilter').val();
                d.class_id = $('#classFilter').val();
                d.status = $('#statusFilter').val();
            },
            error: function(xhr) {
                console.error("⚠️ Gagal memuat data:", xhr.responseText);
            }
        },
        order: [[4, 'desc'], [5, 'desc']],
        columns: [
            { data: 0, title: "ID" },
            { data: 1, title: "Nama Siswa" },
            { data: 3, title: "Email" },
            { data: 2, title: "Kelas" },
            { data: 4, title: "Tanggal" },
            { data: 5, title: "Waktu" },
            { data: 6, title: "Status" },
            { data: 7, title: "Metode" },
            {
                data: 8,
                render: function (data, type, row) {
                    // ✅ Kondisi evidence tampil
                    const metode = row[7];
                    const foto = row[8];
                    const ketTambahan = row[9];

                    if (metode === 'qr') {
                        return '<span style="color:purple;font-weight:bold;">QR Verified</span>';
                    } else if (foto) {
                        return `
                            <a href="/storage/${foto}" target="_blank">
                                <img src="{{ asset('storage/' . $attendance->photo) }}" width="60" height="60" style="border-radius:8px">
                            </a>`;
                    } else if (metode === 'Form' && ketTambahan) {
                        return `<span class="italic text-slate-700">${ketTambahan}</span>`;
                    } else {
                        return '<em>No evidence</em>';
                    }
                }
            }
        ]
    });

    // ✅ Filter realtime (otomatis reload saat user ubah filter)
    $('#dateFilter, #statusFilter, #classFilter').on('change keyup', function () {
        table.ajax.reload();
    });

    // ✅ Export Excel sesuai filter aktif
    $('#exportExcel').on('click', function() {
        const date = $('#dateFilter').val();
        const status = $('#statusFilter').val();
        const class_id = $('#classFilter').val();
        const url = '/admin/attendances/export';
        window.location.href = url;
    });
});
</script>
@endsection
