@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')

<div class="p-6">
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

    <!-- Main Card -->
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-8 py-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Kamera</h2>
                    <p class="text-blue-200 text-sm">Ambil Foto</p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-lg p-4 flex items-start space-x-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-red-700 font-semibold">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 rounded-r-lg p-4 flex items-start space-x-3">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m0-6v-2m0 6v2"/>
                    </svg>
                    <div>
                        <p class="text-yellow-700 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('attendance.qr') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="qr_code" id="qr_code" value="{{ $qr_code }}">

                <!-- Camera Video Feed -->
                <div class="relative bg-slate-900 rounded-lg overflow-hidden shadow-lg border-2 border-slate-300">
                    <video id="camera" autoplay playsinline 
                        class="w-full aspect-video object-cover md:h-auto h-[280px] sm:h-[320px] rounded-lg"
                        style="transform: scaleX(-1);">
                    </video>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-4 right-4 flex items-center space-x-2 bg-green-500/20 backdrop-blur-sm px-3 py-1 rounded-full border border-green-400">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs text-green-200 font-semibold">Live</span>
                        </div>
                    </div>
                </div>

                <!-- Hidden Photo Input -->
                <input type="file" id="photo" name="photo" accept="image/*" capture="camera" style="display:none;">

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" 
                            onclick="takePhoto()"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Ambil Foto
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim
                    </button>
                </div>
            </form>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200 flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900">Cara Check In</h3>
                    <p class="text-sm text-blue-700 mt-1">Tekan "Ambil Foto" untuk mengambil Fotomu, Lalu jangan lupa tekan "Kirim".</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');

    // Akses kamera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => video.srcObject = stream);

    // Capture foto
    function takePhoto() {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(blob => {
            const file = new File([blob], "photo.jpg", { type: "image/jpeg" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('photo').files = dataTransfer.files;
        });
    }
</script>

@endsection