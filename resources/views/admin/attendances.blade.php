@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* 🔹 Tabel styling */
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
    text-align: center;
    vertical-align: middle;
}
tbody tr:hover {
    background-color: #f1f5f9;
}
button {
    transition: all 0.2s ease;
}
button:hover {
    transform: scale(1.03);
}
img {
    max-height: 60px;
    border-radius: 8px;
}
</style>

<div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
    <!-- 🔹 Filter -->
    <div class="flex items-center space-x-3 mb-5">
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

        <button id="exportExcel" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Export Excel
        </button>
    </div>

    <!-- 🔹 Table -->
    <div id="tableArea">
        <div class="text-center text-gray-500 py-4">Loading data...</div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadAttendances() {
    const date = $('#dateFilter').val();
    const status = $('#statusFilter').val();
    const class_id = $('#classFilter').val();

    $('#tableArea').html('<div class="text-center text-gray-500 py-4">Loading data...</div>');

    $.ajax({
        url: "{{ route('admin.attendances.data') }}",
        type: 'GET',
        data: { date, status, class_id },
        success: function(res) {
            if (!res.data || res.data.length === 0) {
                $('#tableArea').html('<div class="text-center text-gray-500 py-4">Belum ada data absensi.</div>');
                return;
            }

            let rows = '';
            res.data.forEach(function(row) {
                const id = row[0] ?? '-';
                const nama = row[1] ?? '-';
                const kelas = row[2] ?? '-';
                const email = row[3] ?? '-';
                const tanggal = row[4] ?? '-';
                const waktu = row[5] ?? '-';
                const status = row[6] ?? '-';
                const metode = row[7] ?? '-';
                const evidence = row[8] ?? '';
                const keterangan = row[9] ?? '';

                let evidenceHTML = '<em>No evidence</em>';
                if (metode === 'qr') {
                    evidenceHTML = '<span style="color:purple;font-weight:bold;">QR Verified</span>';
                } else if (evidence) {
                    evidenceHTML = `<a href="/storage/${evidence}" target="_blank"><img src="/storage/${evidence}"></a>`;
                } else if (keterangan) {
                    evidenceHTML = `<span class="italic text-slate-700">${keterangan}</span>`;
                }

                let statusColor = '';
                if (status === 'Hadir') statusColor = 'text-green-600 font-semibold';
                else if (status === 'Telat') statusColor = 'text-yellow-600 font-semibold';
                else if (status === 'Izin') statusColor = 'text-blue-600 font-semibold';
                else if (status === 'Sakit') statusColor = 'text-purple-600 font-semibold';
                else statusColor = 'text-red-600 font-semibold';

                rows += `
                    <tr class="hover:bg-slate-50">
                        <td>${id}</td>
                        <td>${nama}</td>
                        <td>${kelas}</td>
                        <td>${tanggal}</td>
                        <td>${waktu}</td>
                        <td class="${statusColor}">${status}</td>
                        <td>${metode}</td>
                        <td>${evidenceHTML}</td>
                    </tr>
                `;
            });

            const tableHTML = `
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
                    <tbody>${rows}</tbody>
                </table>
            `;
            $('#tableArea').html(tableHTML);
        },
        error: function(err) {
            console.error(err);
            $('#tableArea').html('<div class="text-center text-red-500 py-4">Gagal memuat data.</div>');
        }
    });
}

// 🔹 Load data awal
$(document).ready(function() {
    loadAttendances();

    // 🔹 Filter realtime
    $('#dateFilter, #statusFilter, #classFilter').on('change input', function() {
        loadAttendances();
    });

    // 🔹 Export Excel
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
