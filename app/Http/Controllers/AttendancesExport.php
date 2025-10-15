<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendancesExport implements FromView, WithTitle
{
    protected $date;
    protected $status;
    protected $class_id;

    public function __construct($date = null, $status = null, $class_id = null)
    {
        $this->date = $date;
        $this->status = $status;
        $this->class_id = $class_id;
    }

    public function view(): View
    {
        $query = Attendance::select(
            'attendances.*',
            'users.name as student_name',
            'users.email',
            'classrooms.name as class_name'
        )
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->leftJoin('classrooms', 'users.class_id', '=', 'classrooms.id');

        if ($this->date) {
            $query->whereDate('attendances.date', $this->date);
        }
        if ($this->status) {
            $query->where('attendances.status', $this->status);
        }
        if ($this->class_id) {
            $query->where('users.class_id', $this->class_id);
        }

        $records = $query->orderByDesc('attendances.date')->get();

        return view('exports.attendances', [
            'records' => $records,
        ]);
    }

    public function title(): string
    {
        return 'Attendance Records';
    }
}
