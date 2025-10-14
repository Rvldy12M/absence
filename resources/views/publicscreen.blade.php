@extends('layouts.app')

@section('title', 'Public Dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="h-screen w-full bg-slate-50 flex flex-col overflow-hidden">
    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col gap-4 p-6">

        <!-- ROW 1: Percentage Summary -->
        <div class="grid grid-cols-5 gap-3 mb-0">
            @foreach(['Hadir'=>'green','Telat'=>'yellow','Izin'=>'blue','Sakit'=>'purple','Alpha'=>'red'] as $label=>$color)
                <div class="flex flex-col justify-center items-center bg-{{ $color }}-50 rounded-xl border border-{{ $color }}-200 shadow-sm p-3 h-28">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-{{ $color }}-500 rounded-full"></div>
                        <span class="font-semibold text-slate-700 text-sm">{{ $label }}</span>
                    </div>
                    <span class="text-2xl font-bold text-{{ $color }}-600 mt-1">
                        {{ $totalStudents > 0 ? round(($attendanceStats[$label] / $totalStudents) * 100) : 0 }}%
                    </span>
                </div>
            @endforeach
        </div>

        <!-- ROW 2: Charts side by side -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Donut Chart -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-col justify-center items-center">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Today's Attendance Overview</h3>
                <div class="relative w-full" style="max-width: 400px; height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-col justify-center items-center">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Attendance by Class</h3>
                <div class="relative w-full" style="max-width: 500px; height: 300px;">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Disable scroll globally -->
<style>
    html, body {
        overflow: hidden;
        height: 100%;
    }
</style>

<!-- Chart.js -->
<script>
const ctxStatus = document.getElementById('attendanceChart').getContext('2d');

// === Chart Donut ===
new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($attendanceStats)) !!},
        datasets: [{
            data: {!! json_encode(array_values($attendanceStats)) !!},
            backgroundColor: [
                'rgba(34,197,94,0.85)',
                'rgba(250,204,21,0.85)',
                'rgba(59,130,246,0.85)',
                'rgba(168,85,247,0.85)',
                'rgba(239,68,68,0.85)',
            ],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        cutout: '60%',
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        responsive: true,
        maintainAspectRatio: false
    }
});

// === Chart Bar ===
new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($classData)) !!},
        datasets: [
            { label: 'Hadir', data: {!! json_encode(array_column($classData, 'Hadir')) !!}, backgroundColor: 'rgba(34,197,94,0.8)' },
            { label: 'Telat', data: {!! json_encode(array_column($classData, 'Telat')) !!}, backgroundColor: 'rgba(250,204,21,0.8)' },
            { label: 'Izin',  data: {!! json_encode(array_column($classData, 'Izin')) !!},  backgroundColor: 'rgba(59,130,246,0.8)' },
            { label: 'Sakit', data: {!! json_encode(array_column($classData, 'Sakit')) !!}, backgroundColor: 'rgba(168,85,247,0.8)' },
            { label: 'Alpha', data: {!! json_encode(array_column($classData, 'Alpha')) !!}, backgroundColor: 'rgba(239,68,68,0.8)' }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            x: { stacked: true },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    // tampilkan hanya angka bulat
                    callback: function(value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    },
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection
