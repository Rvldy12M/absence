<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // jika nama tabel standar 'attendances' maka tidak perlu protected $table

    // Pastikan semua kolom yang akan di-mass assign tercantum di sini
    protected $fillable = [
        'user_id',
        'date',
        'time',
        'status',
        'method',
        'qr_code',
        'notes',
        'photo',
    ];
    

    // Relasi ke User (pakai student_id)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }


}
