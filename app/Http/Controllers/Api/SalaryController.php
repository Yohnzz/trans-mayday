<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryHistory;

class SalaryController extends Controller
{
    public function hitung(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'riwayat' => 'required|array'
    ]);

    $employee = Employee::findOrFail($request->employee_id);

    $gajiJabatanList = [
        'CEO TRANS' => 140000,
        'WAKIL TRANS' => 120000,
        'SUPERVISOR' => 95000,
        'SENIOR' => 75000,
        'JUNIOR' => 65000,
        'MAGANG' => 45000,
    ];

    $GAJI_PER_JAM = 3000;
    $totalJam = 0;

    foreach ($request->riwayat as $item) {
        if (!str_contains($item, '-')) continue;

        [$mulai, $selesai] = explode('-', $item);
        $mulaiMenit = $this->toMenit($mulai);
        $selesaiMenit = $this->toMenit($selesai);

        if ($selesaiMenit <= $mulaiMenit) continue;

        $selisih = $selesaiMenit - $mulaiMenit;
        $jam = floor($selisih / 60);
        $sisa = $selisih % 60;

        if ($sisa > 30) $jam++;
        $totalJam += $jam;
    }

    $gajiJam = $totalJam * $GAJI_PER_JAM;
    $gajiJabatan = $gajiJabatanList[$employee->jabatan] ?? 0;
    $totalGaji = $gajiJam + $gajiJabatan;

    $history = SalaryHistory::create([
        'employee_id' => $employee->id,
        'total_jam' => $totalJam,
        'gaji_per_jam' => $GAJI_PER_JAM,
        'gaji_jabatan' => $gajiJabatan,
        'total_gaji' => $totalGaji,
        'riwayat_duty' => implode("\n", $request->riwayat),
    ]);

    return response()->json([
        'employee' => $employee,
        'total_jam' => $totalJam,
        'gaji_jabatan' => $gajiJabatan,
        'gaji_jam' => $gajiJam,
        'total_gaji' => $totalGaji,
        'history_id' => $history->id
    ]);
}


    private function toMenit($jam)
    {
        $jam = trim(str_replace(',', '.', $jam));
        [$j, $m] = array_pad(explode('.', $jam), 2, 0);
        return ((int)$j * 60) + (int)$m;
    }

    public function history()
{
    return response()->json(
        SalaryHistory::with('employee')
            ->orderBy('created_at', 'desc')
            ->get()
    );
}
}
