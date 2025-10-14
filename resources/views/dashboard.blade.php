@extends('layouts.app')

@section('title', 'Public Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Auth Links - Top Right in Navbar Style -->
@if(Route::has('login'))
    @auth
        @if(Auth::user()->role === 'admin')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-5 py-2.5 rounded-lg text-white font-medium transition-all duration-200 hover:bg-white/10 border border-white/20 hover:border-white/40 bg-blue-600 hover:bg-blue-700">
                    Dashboard
                </a>
            </div>
        @elseif(Auth::user()->role === 'student')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('attendance.index') }}" 
                   class="px-5 py-2.5 rounded-lg text-white font-medium transition-all duration-200 hover:bg-white/10 border border-white/20 hover:border-white/40 bg-blue-600 hover:bg-blue-700">
                    Dashboard
                </a>
            </div>
        @endif
    @else
        <div class="mb-6 flex justify-end gap-3">
            <a href="{{ route('login') }}" 
               class="px-5 py-2.5 rounded-lg bg-white text-blue-900 font-semibold transition-all duration-200 hover:bg-blue-50 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Login
            </a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" 
                   class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold transition-all duration-200 hover:bg-blue-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Register
                </a>
            @endif
        </div>
    @endauth
@endif

<!-- Chart Card - Donut -->
<div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-200 mb-8">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Today's Attendance Overview</h3>
        <p class="text-slate-600">Visual representation of today's attendance status</p>
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
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Attendance by Class</h3>
        <p class="text-slate-600">Breakdown of attendance status per class today</p>
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
                text: 'Today\'s Attendance Distribution',
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
                text: 'Attendance Breakdown by Class',
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
                    font: {
                        size: 12,
                        weight: '600'
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