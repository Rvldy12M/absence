<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class QRController extends Controller
{
    // Halaman form scan / input QR untuk siswa
    public function showForm()
    {
        return view('attendance.qr');
    }

    public function submit(Request $request)
    {
        // 🔹 Validasi awal
        $request->validate([
            'qr_code' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 🔹 Tentukan mode absensi (foto / QR)
        if ($request->hasFile('photo')) {
            // Mode Foto
            $photoPath = $request->file('photo')->store('attendance_photos', 'public');
            $method = 'Photo';
        } elseif ($request->filled('qr_code')) {
            // Mode QR
            if (!$this->isQrValidForToday($request->qr_code)) {
                return back()->with('error', ' Silahkan Ambil Foto terlebih dahulu');
            }
            $photoPath = null;
            $method = 'qr';
        } else {
            return back()->with('error', 'Harap Ambil Foto terlebih dahulu.');
        }

        // 🔹 Data user & tanggal
        $user = Auth::user();
        $today = date('Y-m-d');

        // 🔹 Cegah absen ganda
        $already = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($already) {
            return back()->with('error', 'Kamu sudah absen hari ini');
        }

        // 🔹 Simpan ke database
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $status = 'Hadir';

        if ($now->greaterThan(\Carbon\Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta'))) {
            $status = 'Telat';
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'time' => now()->format('H:i:s'),
            'status' => $status,
            'qr_code' => $request->qr_code,
            'photo' => $photoPath, // simpan path file
            'method' => $method
        ]);

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil dicatat');
    }

    // 🔹 Fungsi untuk validasi QR code sesuai tanggal hari ini
    private function isQrValidForToday($qrCode)
    {
        if (empty($qrCode)) return false;

        // Format QR valid: HADIR-YYYYMMDD
        $todayCode = 'HADIR-' . date('Ymd');
        return $qrCode === $todayCode;
    }

    // 🔹 Generate QR untuk admin
    public function generate()
    {
        $todayCode = 'HADIR-' . date('Ymd'); // kode unik harian
        $qr = QrCode::size(250)->generate($todayCode);

        return view('admin.qr', compact('qr', 'todayCode'));
    }
}
