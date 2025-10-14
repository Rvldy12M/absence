@extends('layouts.app')

@section('title', 'Generate QR')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">QR Hari Ini</h2>
    <p class="mb-4">Kode hari ini: <strong>{{ $todayCode }}</strong></p>

    <div class="flex justify-center mb-4">
        {!! $qr !!}
    </div>
</div>
@endsection
