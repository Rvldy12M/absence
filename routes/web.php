<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use App\Models\Attendance;

// Welcome 
Route::get('/', function () {
    return view('welcome');
});


// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/dashboard', [AdminController::class, 'dashboardpublic'])->name('dashboard');

Route::get('/public', [AttendanceController::class, 'publicscreen'])->name('publicscreen');

// Route untuk student (siswa)
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    // Contoh route tambahan
    Route::get('/attendance/qr', [AttendanceController::class, 'scanQr'])->name('student.attendance.qr');
    Route::get('/attendance/camera', [AttendanceController::class, 'camera'])->name('student.attendance.camera');
});

// Route Izin/sakit
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance/presence', [AttendanceController::class, 'createByStudent'])->name('attendance.form');
    Route::post('/attendance/presence', [AttendanceController::class, 'storeByStudent'])->name('attendance.submit');
});


// Route untuk admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Attendance DataTables
    Route::get('/admin/attendances', [AdminController::class, 'attendances'])->name('admin.attendances');
    Route::get('/admin/attendances/data', [AdminController::class, 'attendancesData'])
    ->name('admin.attendances.data');

    // Student DataTables
    Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/admin/students/data', [AdminController::class, 'studentsData'])->name('admin.students.data');

    // CRUD siswa
    Route::get('/admin/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::post('/admin/students/store', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::get('/admin/students/{id}', [AdminController::class, 'showStudent'])->name('admin.students.show');
    Route::get('/admin/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
    Route::post('/admin/students/{id}/update', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');

    //excel
    Route::get('/admin/attendances/export', [App\Http\Controllers\AdminController::class, 'exportAttendances'])
    ->name('admin.attendances.export');

});


    //QR
    Route::middleware(['auth'])->group(function () {
        // Student input QR
        Route::get('/attendance/qr', [QRController::class, 'showForm'])->name('attendance.qr');
        Route::post('/attendance/qr', [QRController::class, 'submit'])->name('attendance.qr.submit');
    
        // Admin generate QR
        Route::get('/admin/qr/generate', [QRController::class, 'generate'])->name('admin.qr.generate');
    });

    // Lupa Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');