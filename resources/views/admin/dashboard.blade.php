@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Welcome Card -->
<div class="mb-8 bg-gradient-to-r from-blue-900 to-slate-800 rounded-2xl shadow-2xl overflow-hidden">
    <div class="p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-blue-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Chart Card - Donut -->
<div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-200 mb-8">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Kehadiran hari ini </h3>
        <p class="text-slate-600">Representasi visual status kehadiran hari ini</p>
    </div>
    
    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
        <div class="relative mx-auto" style="height: 400px; max-width: 500px;">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <!-- Legend with Percentage -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-8">

        <!-- Hadir -->
        <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl border border-green-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-4 h-4 bg-green-500 rounded-full shadow-sm"></div>
                <span class="font-semibold text-slate-700">Hadir</span>
            </div>
            <span class="text-2xl font-bold text-green-600">
                {{ $totalStudents > 0 ? round(($attendanceStats['Hadir'] / $totalStudents) * 100) : 0 }}%
            </span>
        </div>

        <!-- Telat -->
        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl border border-yellow-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-4 h-4 bg-yellow-400 rounded-full shadow-sm"></div>
                <span class="font-semibold text-slate-700">Telat</span>
            </div>
            <span class="text-2xl font-bold text-yellow-500">
                {{ $totalStudents > 0 ? round(($attendanceStats['Telat'] / $totalStudents) * 100) : 0 }}%
            </span>
        </div>

        <!-- Izin -->
        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl border border-blue-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-4 h-4 bg-blue-500 rounded-full shadow-sm"></div>
                <span class="font-semibold text-slate-700">Izin</span>
            </div>
            <span class="text-2xl font-bold text-blue-600">
                {{ $totalStudents > 0 ? round(($attendanceStats['Izin'] / $totalStudents) * 100) : 0 }}%
            </span>
        </div>

        <!-- Sakit -->
        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-4 h-4 bg-purple-500 rounded-full shadow-sm"></div>
                <span class="font-semibold text-slate-700">Sakit</span>
            </div>
            <span class="text-2xl font-bold text-purple-600">
                {{ $totalStudents > 0 ? round(($attendanceStats['Sakit'] / $totalStudents) * 100) : 0 }}%
            </span>
        </div>

        <!-- Alpha -->
        <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl border border-red-200 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-4 h-4 bg-red-500 rounded-full shadow-sm"></div>
                <span class="font-semibold text-slate-700">Alpha</span>
            </div>
            <span class="text-2xl font-bold text-red-600">
                {{ $totalStudents > 0 ? round(($attendanceStats['Alpha'] / $totalStudents) * 100) : 0 }}%
            </span>
        </div>
    </div>
</div>

<!-- Chart Card - Bar per Kelas -->
<div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-200">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Kehadiran berdasarkan kelas</h3>
        <p class="text-slate-600">Rincian status kehadiran per kelas hari ini</p>
    </div>
    
    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
        <div class="relative" style="height: 450px;">
            <canvas id="classChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxStatus = document.getElementById('attendanceChart').getContext('2d');

// Gradient for Donut Chart
const createGradient = (ctx, color1, color2) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
};

// === Chart Donut (Global) ===
new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($attendanceStats)) !!},
        datasets: [{
            data: {!! json_encode(array_values($attendanceStats)) !!},
            backgroundColor: [
                'rgba(34,197,94,0.85)',   // Hadir
                'rgba(250,204,21,0.85)',  // Telat
                'rgba(59,130,246,0.85)',  // Izin
                'rgba(168,85,247,0.85)',  // Sakit
                'rgba(239,68,68,0.85)',   // Alpha
            ],
            borderColor: '#ffffff',
            borderWidth: 4,
            hoverOffset: 20,
            hoverBorderWidth: 5,
            hoverBorderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: {
            legend: { 
                display: false  // Hide legend karena sudah ada legend cards di bawah
            },
            title: {
                display: true,
                font: { 
                    size: 18,
                    weight: 'bold',
                    family: "'Inter', sans-serif"
                },
                color: '#1e293b',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.parsed || 0;
                        let total = {{ $totalStudents }};
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' students (' + percentage + '%)';
                    }
                }
            }
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 1500,
            easing: 'easeInOutQuart'
        }
    }
});

// === Chart Bar (Per Kelas) ===
const classLabels = {!! json_encode(array_keys($classData)) !!};
const classDatasets = [
    {
        label: 'Hadir',
        backgroundColor: 'rgba(34,197,94,0.85)',
        borderColor: 'rgba(34,197,94,1)',
        borderWidth: 2,
        borderRadius: 8,
        data: {!! json_encode(array_column($classData, 'Hadir')) !!}
    },
    {
        label: 'Telat',
        backgroundColor: 'rgba(250,204,21,0.85)',
        borderColor: 'rgba(250,204,21,1)',
        borderWidth: 2,
        borderRadius: 8,
        data: {!! json_encode(array_column($classData, 'Telat')) !!}
    },
    {
        label: 'Izin',
        backgroundColor: 'rgba(59,130,246,0.85)',
        borderColor: 'rgba(59,130,246,1)',
        borderWidth: 2,
        borderRadius: 8,
        data: {!! json_encode(array_column($classData, 'Izin')) !!}
    },
    {
        label: 'Sakit',
        backgroundColor: 'rgba(168,85,247,0.85)',
        borderColor: 'rgba(168,85,247,1)',
        borderWidth: 2,
        borderRadius: 8,
        data: {!! json_encode(array_column($classData, 'Sakit')) !!}
    },
    {
        label: 'Alpha',
        backgroundColor: 'rgba(239,68,68,0.85)',
        borderColor: 'rgba(239,68,68,1)',
        borderWidth: 2,
        borderRadius: 8,
        data: {!! json_encode(array_column($classData, 'Alpha')) !!}
    }
];

new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: { 
        labels: classLabels, 
        datasets: classDatasets 
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            title: {
                display: true,
                font: { 
                    size: 18,
                    weight: 'bold',
                    family: "'Inter', sans-serif"
                },
                color: '#1e293b',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            legend: { 
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12,
                        weight: '600'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                cornerRadius: 8,
                displayColors: true
            }
        },
        scales: {
            x: { 
                stacked: true,
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12,
                        weight: '600'
                    },
                    color: '#475569'
                }
            },
            y: { 
                stacked: true, 
                beginAtZero: true,
                grid: {
                    color: 'rgba(148, 163, 184, 0.1)',
                    borderDash: [5, 5]
                },
                ticks: {
                    // tampilkan hanya angka bulat
                    callback: function(value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    },
                    color: '#475569'

                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeInOutQuart'
        }
    }
});
</script>

@endsection