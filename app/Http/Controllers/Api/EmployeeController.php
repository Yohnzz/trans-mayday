<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // GET /api/employees
    public function index()
    {
        return response()->json(
            Employee::orderBy('nama')->get()
        );
    }

    // POST /api/employees
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string'
        ]);

        $employee = Employee::create([
            'nama' => $request->nama,
            'jabatan' => strtoupper($request->jabatan)
        ]);

        return response()->json([
            'success' => true,
            'data' => $employee
        ], 201);
    }
    public function destroy(Request $request, $id)
{
    // 1. Cari data berdasarkan ID
    $employee = Employee::find($id);

    // Cek jika data tidak ditemukan agar tidak error 500
    if (!$employee) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    // 2. Hapus data
    $employee->delete();

    // 3. Return JSON (Bukan redirect)
    return response()->json([
        'success' => true,
        'message' => 'Data pegawai berhasil dihapus'
    ], 200);
}
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string',
        'jabatan' => 'required|string'
    ]);

    $employee = Employee::findOrFail($id);

    $employee->nama = $request->nama;
    $employee->jabatan = strtoupper($request->jabatan);
    $employee->save();

    return response()->json([
        'success' => true,
        'data' => $employee
    ]);
}


}
