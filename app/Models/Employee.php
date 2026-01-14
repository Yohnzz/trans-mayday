<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['nama', 'jabatan'];

    public function salaries()
    {
        return $this->hasMany(SalaryHistory::class);
    }
}
