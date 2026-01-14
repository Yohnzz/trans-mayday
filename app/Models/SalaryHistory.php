<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'total_jam',
        'gaji_per_jam',
        'gaji_jabatan',
        'total_gaji',
        'riwayat_duty'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
