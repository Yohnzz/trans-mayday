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
