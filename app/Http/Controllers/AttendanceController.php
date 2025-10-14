<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Classroom;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use Illuminate\Support\Facades\DB;



class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student')
            ->where('user_id', Auth::id()) // hanya data siswa login
            ->orderBy('date', 'desc')
            ->get();
        $qr_code = $qr_code = 'QR-' . now()->format('Ymd');
        return view('attendance.index', compact('attendances','qr_code'));
        
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'method' => 'required|string'
        ]);

        Attendance::create([
            'user_id' => Auth::id(),
            'date'       => now()->toDateString(),
            'time'       => now()->toTimeString(),
            'status'     => $request->status,
            'method'     => $request->method
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully!');
    }

    public function scanQr()
    {
        return view('attendance.qr');
    }

    public function camera()
    {
        return view('attendance.camera');
    }


    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        // Cegah absen 2x dalam 1 hari
        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();
        if ($existing) {
            return back()->with('error', 'Kamu sudah absen hari ini.');
        }

        // Waktu sekarang
        $now = Carbon::now();
        $limit = Carbon::createFromTimeString(config('attendance.start_time'));

        // Tentukan status
        $status = $now->gt($limit) ? 'late' : 'present';

        // Simpan foto (jika ada)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('attendance_photos', 'public');
        }

        // Simpan data absen
        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'check_in_time' => $now->format('H:i:s'),
            'status' => $status,
            'method' => $request->has('qr_code') ? 'qr' : 'photo',
            'photo' => $photoPath,
            'qr_code' => $request->qr_code,
        ]);

        return back()->with('success', "Absen berhasil! Status kamu hari ini: $status");

    }


public function createByStudent()
{
    return view('attendance.form');
}

public function storeByStudent(Request $request)
{
    $request->validate([
        'status' => 'required|in:Hadir,Sakit,Izin',
        'notes' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();
    $now = Carbon::now('Asia/Jakarta');
    $time = $now->format('H:i:s');
    $date = $now->toDateString();

    $status = $request->status;

    // Kalau lewat jam 07:00 dan status "Present" → ubah jadi Late
    if ($status === 'Present' && $time > '07:00:00') {
        $status = 'Late';
    }

    // Cegah double absen di hari yang sama
    $already = Attendance::where('user_id', $user->id)
        ->whereDate('date', $date)
        ->first();

    if ($already) {
        return redirect()->back()->with('error', 'Kamu sudah absen hari ini!');
    }

    Attendance::create([
        'user_id' => $user->id,
        'date' => $date,
        'time' => $time,
        'status' => $status,
        'method' => 'Form',
        'notes' => $request->notes,
        'photo' => null,
    ]);

    return redirect()->back()->with('success', 'Absen berhasil disimpan!');
}

public function publicscreen()
{
    $today = Carbon::today('Asia/Jakarta');

    // Total siswa
    $totalStudents = User::where('role', 'student')->count();

    // Hitung per status (hari ini)
    $todayPresent = Attendance::whereDate('date', $today)->where('status', 'Hadir')->count();
    $todayTelat   = Attendance::whereDate('date', $today)->where('status', 'Telat')->count();
    $todayIzin    = Attendance::whereDate('date', $today)->where('status', 'Izin')->count();
    $todaySakit   = Attendance::whereDate('date', $today)->where('status', 'Sakit')->count();
    $todayAlpha   = $totalStudents - ($todayPresent + $todayTelat + $todayIzin + $todaySakit);

    // Data untuk chart global
    $attendanceStats = [
        'Hadir' => $todayPresent,
        'Telat' => $todayTelat,
        'Izin'  => $todayIzin,
        'Sakit' => $todaySakit,
        'Alpha' => max($todayAlpha, 0),
    ];

    // Chart per kelas
    $classes = User::where('role', 'student')->select('class_id')->distinct()->pluck('class_id');
    $classData = [];

    foreach ($classes as $class) {
        $studentsInClass = User::where('class_id', $class)->count();

        $present = Attendance::whereDate('date', $today)
            ->where('status', 'Hadir')
            ->whereHas('user', fn($q) => $q->where('class_id', $class))
            ->count();

        $telat = Attendance::whereDate('date', $today)
            ->where('status', 'Telat')
            ->whereHas('user', fn($q) => $q->where('class_id', $class))
            ->count();

        $izin = Attendance::whereDate('date', $today)
            ->where('status', 'Izin')
            ->whereHas('user', fn($q) => $q->where('class_id', $class))
            ->count();

        $sakit = Attendance::whereDate('date', $today)
            ->where('status', 'Sakit')
            ->whereHas('user', fn($q) => $q->where('class_id', $class))
            ->count();

        $alpha = $studentsInClass - ($present + $telat + $izin + $sakit);

        $classData[$class] = [
            'Hadir' => $present,
            'Telat' => $telat,
            'Izin'  => $izin,
            'Sakit' => $sakit,
            'Alpha' => max($alpha, 0),
        ];
    }

    return view('publicscreen', compact(
        'totalStudents',
        'attendanceStats',
        'classData'
    ));
}



}